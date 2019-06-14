<?php

namespace App\Http\Controllers;

use App\Common;
use App\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Grafika\Grafika;
use Image;


class MainController extends Controller {




    private $image_info = array();
    private $related_images = array();





    // DISPLAY THE SPLASH PAGE
    // route to Splash Page goes through here
    public function index() {

        // query to get number of available rows
        $total_available_skus = Sku::where('status', '=', null)
            ->count();

        // send user to the view, with total available rows from db (string "0" or larger number "1,002")
        return view('splash')
            ->with('total', number_format($total_available_skus));
    }





    // RESPONSE TO A USER ACTION
    // user has sent us a SKU
    public function manual_sku(Request $request) {

        // request a new hash
        $hash = Common::get_new_hash();

        // create a new batch record
        DB::table('batch_info')->insert(
            ['name' => 'Single SKU ' .$request->sku,
            'priority' => 9999]
        );

        // request ID from the above insert, to be used in the following insert
        $batch_id = DB::getPdo()->lastInsertId();

        // create a db record for this one-off SKU
        $sku = new Sku;

        $sku->batch_id = $batch_id;
        $sku->sku = $request->sku;
        $sku->status = 10;
        $sku->hash_id = $hash;

        $sku->save();

        // send user to the WORK ZONE, so they may create this new image
        return redirect()->route('work_zone', ['hash_id' => $hash]);
    }





    // RESPONSE TO A USER ACTION
    // user wants to work on the next available SKU
    public function next_available() {

        // go out and get the HASH_ID of the next item
        $hash_id = $this->get_next_item();

        // if a HASH_ID is returned...
        if ($hash_id) {

            // the item has been tagged, now send user to WORK ZONE and pass along the HASH_ID
            return redirect()->route('work_zone', ['hash_id' => $hash_id]);

        } else {

            dd('The queue is empty!');

        }

    }





    // HELPER METHOD
    // selects an available item to work on. Based upon status (null), sorted by priority, created_at, then id. returns
    // this item's HASH_ID
    protected function get_next_item() {

        // prep a var to hold the item's HASH_ID
        $hash_id = null;

        // query to get number of available rows
        $total_available_skus = Sku::where('status', '=', null)
            ->count();

        // if there are available any rows...
        if ($total_available_skus > 0) {

            // ...request a new hash_id. This will be used to identify a row (a specific SKU, but since there could be
            // duplicate SKUs, it is for this one row)
            $hash_id = Common::get_new_hash();

            // target the next available item
            $next_item = DB::table('sku_data')
                ->join('batch_info', 'sku_data.batch_id', '=', 'batch_info.batch_id')
                ->select('sku_data.id')
                ->where('sku_data.status', '=', null)
                ->orderBy('batch_info.priority', 'ASC')
                ->orderBy('sku_data.created_at', 'ASC')
                ->orderBy('sku_data.id', 'ASC')
                ->limit(1)
                ->get();

            // we need the row ID...
            $id = $next_item[0]->id;

            // ...so we can update the STATUS and add the HASH_ID
            Sku::where('id', $id)
                ->update([
                    'status' => 10,
                    'hash_id' => $hash_id
                ]);
        }

        // sends back a HASH_ID or a null
        return $hash_id;
    }





    // DISPLAY THE WORK ZONE
    // allow the user to work on an image
    public function work_zone($hash_id) {

        $request = DB::table('sku_data')
            ->where('hash_id', '=', $hash_id)
            ->get();

        $this->image_info['sku_data'] = $request[0];

        $this->gather($request[0]->sku, $hash_id, $request[0]->akamai_numbers);

        if ($request[0]->status >= 20) {

            // if condition is met, we will need to bring in the most recent telemetry
            // and append that to the image_info object
            $request2 = DB::table('telemetry_data')
                ->where('hash_id', '=', $hash_id)
                ->orderBy('created_at', 'DESC')
                ->limit(1)
                ->get();

            $this->image_info['telemetry'] = $request2[0]->data;

            // we have to extract the button text from the JSON
            $json = json_decode($this->image_info['telemetry']);

            // ...and send it as a readable varaible, in order to simplify on the VIEW side
            $this->image_info['line_1'] = $json->text->line_1;
            $this->image_info['line_2'] = $json->text->line_2;
        }

        // gather up to 6 recently created icon/images
        $results = DB::table('sku_data')
            ->where('status', '=', 20)
            ->orderBy('updated_at', 'DESC')
            ->limit(6)
            ->get();

        if ($results) {

            foreach ($results as $result) {

                $image = array();
                $image['batch_id'] = $result->batch_id;
                $image['sku'] = $result->sku;
                $image['hash_id'] = $result->hash_id;
                $image['line1'] = $result->line1_text;
                $image['line2'] = $result->line2_text;

                array_push($this->related_images, $image);
            }
        }

        return view('work_zone', ['image_info' => $this->image_info, 'related_images' => $this->related_images]);
    }





    // HELPER METHOD
    // gather images from all available sources
    protected function gather($sku, $hash_id, $akamai_numbers) {

        // track the total images available for a sku (across all sources)
        $this->image_info['total_images'] = 0;
        $this->image_info['image_numbers'] = array();

        // akamai images provided
        if ($akamai_numbers) {

            // incoming comma delimited string from batch data
            $x_numbers = explode(',', $akamai_numbers);

            // increment the total count
            $this->image_info['total_images'] += count($x_numbers);

            // add each one of these image numbers to the master array of such things
            for ($x = 0; $x < count($x_numbers); $x++) {
                array_push($this->image_info['image_numbers'], $x_numbers[$x]);
            }

        }

//
//        // fetch images from IMS (snumbers)
//        $results = $this->fetch_s_numbers($sku);
//
//        if (count($results)) {
//
//            $this->build_image_data($results);
//        }
//
//        // fetch images from MIS (marketplace)
//        $results = $this->fetch_m_numbers($sku);
//
//        if (count($results)) {
//
//            $this->build_image_data($results);
//        }

        return true;
    }





    // HELPER METHOD
    // new IMS is the repository for S-Numbers
    protected function fetch_s_numbers($sku) {

        // sNUMBERS
        // URL format: https://www.staples-3p.com/s7/is/image/Staples/s1030803_sc7?wid=512&hei=512

        $images = DB::connection('mysql-new-ims')
            ->table('images')
            ->select('snumber')
            ->whereRaw("MATCH(sku) AGAINST('" .$sku. "' IN BOOLEAN MODE)")
            ->where('image_type_id', '=', 1)
            ->orderBy('updated_at', 'DESC')
            //->limit(3)
            ->get();

        foreach ($images as $image) {
            $image->image_id = strtolower($image->snumber);
        }

        return $images;
    }





    // HELPER METHOD
    // marketplace (MIS) is the repository for M-Numbers
    protected function fetch_m_numbers($sku) {

        // MARKETPLACE
        // URL format: https://www.staples-3p.com/s7/is/image/Staples/m001282706_sc7?wid=512&hei=512

        $images = DB::connection('mysql-marketplace')
            ->table('metadata')
            ->select('image_id')
            ->where('sku', '=', $sku)
            ->orderBy('modified', 'DESC')
            //->limit(3)
            ->get();

        foreach ($images as $image) {
            $image->image_id = 'm' .str_pad($image->image_id, 9, "0", STR_PAD_LEFT);
        }

        return $images;
    }





    // HELPER METHOD
    // update count and push images into an array of all images
    protected function build_image_data($results) {

        // increment total
        $this->image_info['total_images'] += count($results);

        foreach ($results as $result) {
            array_push($this->image_info['image_numbers'], $result->image_id);
        }

        return true;
    }





    // HELPER METHOD
    protected function save_and_create(Request $request) {

        // take the incoming hash_id
        $hash_id = $request->hash_id;

        // ...and look-up the sku_data for that unique version
        $data = Sku::where('hash_id', $hash_id)
            ->limit(1)
            ->get();

        // grab the sku, we will need this for file-naming later on
        $sku = $data[0]['sku'];


        // update the STATUS and the LINES OF TEXT
        Sku::where('hash_id', $hash_id)
            ->update([
                'line1_text' => $request->line1_text,
                'line2_text' => $request->line2_text,
                'status' => 20
            ]);

        // create TELEMETRY DATA and build the image(s)
        $arr = array();

        $arr['text'] = array();
            $arr['text']['line_1'] = $request->line1_text;
            $arr['text']['line_2'] = $request->line2_text;

        $arr['layer-a'] = array();
            $arr['layer-a']['url'] = $request->url_0;
            $arr['layer-a']['rotation'] = number_format((float)$request->rotation_0, 2, '.', '');
            $arr['layer-a']['scale'] = number_format((float)$request->scale_0, 3, '.', '');
            $arr['layer-a']['x_offset_js'] = round($request->x_offset_js_0);
            $arr['layer-a']['y_offset_js'] = round($request->y_offset_js_0);
            $arr['layer-a']['x_offset_gsap'] = round($request->x_offset_gsap_0);
            $arr['layer-a']['y_offset_gsap'] = round($request->y_offset_gsap_0);

        $layers = 1;

        // create a new empty image resource with white background
        $img = Image::canvas(474, 474, '#ffffff');

        // create a new image object from the (now local) target image file
        $layer = Image::make($arr['layer-a']['url']);

        // scale as necessary
        $pixels = $arr['layer-a']['scale'] * 1000;
        $layer->resize($pixels, $pixels);

        // rotate as necessary
        $rotate = 0;
        if ($arr['layer-a']['rotation'] < 0) {
            $rotate = abs($arr['layer-a']['rotation']);
        } else {
            $rotate = -$arr['layer-a']['rotation'];
        }
        $layer->rotate($rotate);

        // paste image object onto canvas with desired X,Y offset
        $img->insert($layer, 'top-left', $arr['layer-a']['x_offset_js'], $arr['layer-a']['y_offset_js']);

        $img->contrast(2);

        // save the image
        $img->save('storage/images/' .$sku. '_' .$hash_id. '1.jpg', 100);

        // free-up memory
        $layer->destroy();
        $img->destroy();


        if ($request->url_1) {

            $arr['layer-b'] = array();
                $arr['layer-b']['url'] = $request->url_1;
                $arr['layer-b']['rotation'] = number_format((float)$request->rotation_1, 2, '.', '');
                $arr['layer-b']['scale'] = number_format((float)$request->scale_1, 2, '.', '');
                $arr['layer-b']['x_offset_js'] = round($request->x_offset_js_1);
                $arr['layer-b']['y_offset_js'] = round($request->y_offset_js_1);
                $arr['layer-b']['x_offset_gsap'] = round($request->x_offset_gsap_1);
                $arr['layer-b']['y_offset_gsap'] = round($request->y_offset_gsap_1);

            $layers = 2;

            // create a new empty image resource with white background
            $img = Image::canvas(474, 474, '#ffffff');

            // create a new image object from the (now local) target image file
            $layer = Image::make($arr['layer-b']['url']);

            // scale as necessary
            $pixels = $arr['layer-b']['scale'] * 1000;
            $layer->resize($pixels, $pixels);

            // rotate as necessary
            $rotate = 0;
            if ($arr['layer-b']['rotation'] < 0) {
                $rotate = abs($arr['layer-b']['rotation']);
            } else {
                $rotate = -$arr['layer-b']['rotation'];
            }
            $layer->rotate($rotate);

            // paste image object onto canvas with desired X,Y offset
            $img->insert($layer, 'top-left', $arr['layer-b']['x_offset_js'], $arr['layer-b']['y_offset_js']);

            $img->contrast(2);

            // save the image
            $img->save('storage/images/' .$sku. '_' .$hash_id. '2.jpg', 100);

            // free-up memory
            $layer->destroy();
            $img->destroy();

        }

        if ($request->url_2) {

            $arr['layer-c'] = array();
            $arr['layer-c']['url'] = $request->url_2;
            $arr['layer-c']['rotation'] = number_format((float)$request->rotation_2, 2, '.', '');
            $arr['layer-c']['scale'] = number_format((float)$request->scale_2, 2, '.', '');
            $arr['layer-c']['x_offset_js'] = round($request->x_offset_js_2);
            $arr['layer-c']['y_offset_js'] = round($request->y_offset_js_2);
            $arr['layer-c']['x_offset_gsap'] = round($request->x_offset_gsap_2);
            $arr['layer-c']['y_offset_gsap'] = round($request->y_offset_gsap_2);

            $layers = 3;

            // create a new empty image resource with white background
            $img = Image::canvas(474, 474, '#ffffff');

            // create a new image object from the (now local) target image file
            $layer = Image::make($arr['layer-c']['url']);

            // scale as necessary
            $pixels = $arr['layer-c']['scale'] * 1000;
            $layer->resize($pixels, $pixels);

            // rotate as necessary
            $rotate = 0;
            if ($arr['layer-c']['rotation'] < 0) {
                $rotate = abs($arr['layer-c']['rotation']);
            } else {
                $rotate = -$arr['layer-c']['rotation'];
            }
            $layer->rotate($rotate);

            // paste image object onto canvas with desired X,Y offset
            $img->insert($layer, 'top-left', $arr['layer-c']['x_offset_js'], $arr['layer-c']['y_offset_js']);

            $img->contrast(2);

            // save the image
            $img->save('storage/images/' .$sku. '_' .$hash_id. '3.jpg', 100);

            // free-up memory
            $layer->destroy();
            $img->destroy();

        }

        // write out the telemetry data
        DB::table('telemetry_data')->insert(
            ['hash_id' => $request->hash_id,
                'data' => json_encode($arr)]
        );


        // save the final image, compositing if there are multiple layers
        $editor = Grafika::createEditor(); // Create the best available editor
        $layer1 = Grafika::createImage('storage/images/' .$sku. '_' .$hash_id. '1.jpg', 100);

        if ($layers > 1) {

            $layer2 = Grafika::createImage('storage/images/' .$sku. '_' .$hash_id. '2.jpg', 100);
            $editor->blend($layer1, $layer2, 'multiply', 1, 'center');
            $editor->free($layer2);
            @unlink('storage/images/' .$sku. '_' .$hash_id. '2.jpg');

            if ($layers > 2) {
                $layer3 = Grafika::createImage('storage/images/' .$sku. '_' .$hash_id. '3.jpg', 100);
                $editor->blend($layer1, $layer3, 'multiply', 1, 'center');
                $editor->free($layer3);
                @unlink('storage/images/' .$sku. '_' .$hash_id. '3.jpg');
            }
        }

        $button_name = $sku. '_' .$hash_id. '.png';

        $editor->save($layer1, 'storage/images/' .$button_name, 'png', 100);
        @unlink('storage/images/' .$sku. '_' .$hash_id. '1.jpg');

        // if image exists
        if (file_exists( public_path() . '/storage/images/' . $button_name)) {
            Sku::where('hash_id', $hash_id)
                ->update([
                    'button_filename' => $button_name
                ]);
        }


        dd('Data saved and images created');
    }


































































    // EARLIER WORK AND TESTS - TO BE DELETED



    public function process_images(Request $request) {

        $layers = 1;

        // create a new empty image resource with white background
        $img = Image::canvas(474, 474, '#ffffff');

        // create a new image object from the (now local) target image file
        $layer = Image::make($request->url_0);

        // scale as necessary
        $pixels = $request->scale_0 * 1000;
        $layer->resize($pixels, $pixels);

        // rotate as necessary
        $rotate = 0;
        if ($request->rotate_0 < 0) {
            $rotate = abs($request->rotation_0);
        } else {
            $rotate = -$request->rotation_0;
        }
        $layer->rotate($rotate);

        // paste image object onto canvas with desired X,Y offset
        $img->insert($layer, 'top-left', round($request->offsetx_0), round($request->offsety_0));

        // save the image
        $img->save('storage/images/layer1.jpg', 100);

        // free-up memory
        $layer->destroy();
        $img->destroy();


        if ($request->url_1) {

            $layers = 2;

            // create a new empty image resource with white background
            $img = Image::canvas(474, 474, '#ffffff');

            // create a new image object from the (now local) target image file
            $layer = Image::make($request->url_1);

            // scale as necessary
            $pixels = $request->scale_1 * 1000;
            $layer->resize($pixels, $pixels);

            // rotate as necessary
            $rotate = 0;
            if ($request->rotate_1 < 0) {
                $rotate = abs($request->rotation_1);
            } else {
                $rotate = -$request->rotation_1;
            }
            $layer->rotate($rotate);

            // paste image object onto canvas with desired X,Y offset
            $img->insert($layer, 'top-left', round($request->offsetx_1), round($request->offsety_1));

            // save the image
            $img->save('storage/images/layer2.jpg', 100);

            // free-up memory
            $layer->destroy();
            $img->destroy();
        }


        if ($request->url_2) {

            $layers = 3;

            // create a new empty image resource with white background
            $img = Image::canvas(474, 474, '#ffffff');

            // create a new image object from the (now local) target image file
            $layer = Image::make($request->url_2);

            // scale as necessary
            $pixels = $request->scale_2 * 1000;
            $layer->resize($pixels, $pixels);

            // rotate as necessary
            $rotate = 0;
            if ($request->rotate_2 < 0) {
                $rotate = abs($request->rotation_2);
            } else {
                $rotate = -$request->rotation_2;
            }
            $layer->rotate($rotate);

            // paste image object onto canvas with desired X,Y offset
            $img->insert($layer, 'top-left', round($request->offsetx_2), round($request->offsety_2));

            // save the image
            $img->save('storage/images/layer3.jpg', 100);

            // free-up memory
            $layer->destroy();
            $img->destroy();
        }

        $editor = Grafika::createEditor(); // Create the best available editor
        $layer1 = Grafika::createImage('storage/images/layer1.jpg');

        if ($layers > 1) {

            $layer2 = Grafika::createImage('storage/images/layer2.jpg');
            $editor->blend($layer1, $layer2, 'multiply', 1, 'center');
            $editor->free($layer2);

            if ($layers > 2) {
                $layer3 = Grafika::createImage('storage/images/layer3.jpg');
                $editor->blend($layer1, $layer3, 'multiply', 1, 'center');
                $editor->free($layer3);
            }

            $editor->save($layer1, 'storage/images/composite.png', 'png', 100);
        }


        $layer4 = Grafika::createImage('images/circle_mask_dome_white.png');
        $editor->blend($layer1, $layer4, 'normal', 1, 'center');
        $editor->free($layer4);

        $editor->save($layer1, 'storage/images/composite_with_dome.png', 'png', 100);

        return view('images', ['text'=>$request->button_text]);
    }



























}
