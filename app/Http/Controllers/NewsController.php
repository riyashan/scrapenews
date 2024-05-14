<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;




use Image;
use Imagick;
use DB;
use File;


class NewsController extends Controller
{
   
    public function makepdf(Request $request){

        $date = $request->selDate;
        $newstype = $request->selNewsType;
        $url = $request->url;
        $status = '0';

        //dd($request);

        if($newstype=='1' && !empty($date)) { 

            $news_record_val = News::where('news_paper_type',"=",$newstype)
            ->where('status',"=",$status)->where('news_date',"=",$date)
            ->get();

            foreach ($news_record_val as $val) {

                $cover_photo = $val->cover_photo;
                $cover_exp = explode("/", $cover_photo);
                $sub_folder_name = $cover_exp[5];
                $file_name = $val->file_name;
                $file_exp = explode("/", $file_name);
                $ori_file_name = $file_exp[5];

                $images = [];
                foreach(glob("app/public/news/nst/$date/$sub_folder_name/images/*.*") as $file) {
                    $images[] = $file;
                }
                natsort($images);

                $pdf = new Imagick($images);
                $pdf->setImageFormat('pdf');
                $pdf->writeImages("app/public/news/nst/$date/$ori_file_name", true); 

                //Remove the Files
                $targetfolder = 'app/public/news/nst/'.$date.'/'.$sub_folder_name.'/images';
                File::deleteDirectory($targetfolder);

            }

            echo "Success";
        }else if($newstype=='2' && !empty($date)) { 

            $news_record_val = News::where('news_paper_type',"=",$newstype)
            ->where('status',"=",$status)->where('news_date',"=",$date)
            ->get();

            foreach ($news_record_val as $val) {

                $cover_photo = $val->cover_photo;
                $cover_exp = explode("/", $cover_photo);
                $sub_folder_name = $cover_exp[5];
                $file_name = $val->file_name;
                $file_exp = explode("/", $file_name);
                $ori_file_name = $file_exp[5];

                $images = [];
                foreach(glob("app/public/news/star/$date/$sub_folder_name/images/*.*") as $file) {
                    $images[] = $file;
                }
                natsort($images);
    
                $pdf = new \Imagick($images);
                $pdf->setImageFormat('pdf');
                $pdf->writeImages("app/public/news/star/$date/$ori_file_name", true);

                //Remove the Files
                $targetfolder = 'app/public/news/star/'.$date.'/'.$sub_folder_name.'/images';
                File::deleteDirectory($targetfolder);

            }

            echo "Success";
        }else if($newstype=='3' && !empty($url)) { 

            $client = new Client();

            //  Hackery to allow HTTPS
            $guzzleclient = new \GuzzleHttp\Client([
                'timeout' => 600,
                'verify' => false,
            ]);


            $crawler = $client->request(
                'GET',
                $url
            );

            $twitter_url = $crawler->filter("meta[name='twitter:image']")->extract(['content']);

            $exp_twitter_url = explode('/', $twitter_url[0]);
            $url_val = $exp_twitter_url['3'];

            $url_content = explode('/', $url);
            $publisher_name = $url_content['3'];
            $file_name_content = $url_content['5'];

            if(!empty($url_val)){
                $images = [];
                foreach(glob("app/public/news/ozark/$url_val/images/*.*") as $file) {
                    $images[] = $file;
                }
                natsort($images);
            
                $file_name = "($publisher_name)_$file_name_content";
                $pdf = new Imagick($images);
                $pdf->setImageFormat('pdf');
                $pdf->writeImages("app/public/news/ozark/$url_val/$file_name.pdf", true); 
                
                 //Remove the Files
                $targetfolder = 'app/public/news/ozark/'.$url_val.'/images';
                File::deleteDirectory($targetfolder);
            
                echo "Success";
            }
        }
    }

    public function scrapedata(Request $request){
        $date = $request->date;
        $news_type = $request->news_type;
        $url = $request->url;
        
        $now = Carbon::now();
        $current_time = Carbon::now();
        $status = '0';
        $today = $now->toDateString();
        $year = date('Y', strtotime($date));
        //die;
        $current_time = Carbon::now();
        $time = $now->format("H:i"); 

        if($news_type == '3' || $news_type == '4'){
            if($news_type=='3'){ 
                if(!empty($url) && !empty($news_type)){

                    $news_record = News::where('news_paper_type',"=",$news_type)
                    ->where('status',"=",$status)->where('news_date',"=",$today)
                    ->get();
                    $number_of_rows = $news_record->count();
                    $new_number_of_rows = $number_of_rows + 1;
                    $url_content = explode('/', $url);
                    $publisher_name = $url_content['3'];
                    
                    $file_name_content = $url_content['5'];

                    $client = new Client();

                    //  Hackery to allow HTTPS
                    $guzzleclient = new \GuzzleHttp\Client([
                        'timeout' => 600,
                        'verify' => false,
                    ]);


                    $crawler = $client->request(
                        'GET',
                        $url
                    );

                    $twitter_url = $crawler->filter("meta[name='twitter:image']")->extract(['content']);

                    $exp_twitter_url = explode('/', $twitter_url[0]);
                    $url_val = $exp_twitter_url['3'];
                    //die;


        
                    if(!empty($url_val)){
        
                        for($i = 1; $i<=75; $i++) {
                            
        
                            $targetfolder = 'app/public/news/ozark/'.$url_val.'/images';
                            $targetfolder_cover = 'app/public/news/ozark/'.$url_val.'/cover_photo';
                            if (!file_exists($targetfolder)) {
                                mkdir($targetfolder, 0777, true);
                            }
            
                            if (!file_exists($targetfolder_cover)) {
                                mkdir($targetfolder_cover, 0777, true);
                            } 
        
                            $image_url = "https://image.isu.pub/$url_val/jpg/page_$i.jpg";
                            //die;
        
                            $save_as = "$targetfolder/$i.jpg";
                            $ch = curl_init($image_url);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                            $raw_data = curl_exec($ch);
                            $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                            //print_r($response_status);
                            curl_close($ch); 
                            
                        if(empty($raw_data))
                            {
                                echo 'Empty Result';
                                die;
                            }else{
                                if ($response_status == 200) {
                                    if(file_exists($save_as)){
                                        unlink($save_as);
                                    }
                                    $image = Image::make($image_url);
                                    $image->resize(null, 1800, function ($constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    });
                                    $image->save($save_as, 50);
        
                                    $no_of_pages = $i;
                                }else{
                                    break;
                                }
        
                                if($i=='1'){
                                    //echo 'here';
                                    $save_as = "$targetfolder_cover/cover.jpg";
                                    if(file_exists($save_as)){
                                        unlink($save_as);
                                    }
                                    $image = Image::make($image_url);
                                    $image->resize(null, 1800, function ($constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    });
                                    $image->save($save_as, 50);
                                }
                            } 
                        }
        
                        $file_name = "($publisher_name)_$file_name_content";
                        $targetfolder_cover_ch = 'app/public/news/ozark/'.$url_val.'/cover_photo';
                        $cover_photo = "$targetfolder_cover_ch/cover.jpg";
                        $db_file_name = "app/public/news/ozark/$url_val/$file_name.pdf";
                    

                        $news = new News;
                        $news->news_paper_type = '3';
                        $news->news_date = $today;
                        $news->cover_photo = $cover_photo;
                        $news->file_name = $db_file_name;
                        $news->no_of_pages = $no_of_pages;
                        $news->created_by = '1';
                        $news->created_at = $current_time;
                        $news->sequence = $new_number_of_rows;
                        $news->save();
        

                        echo "Success";

                    }else{
                        echo "Invalid";
                    }
                }
            }
        }else{
            if(!empty($date) && !empty($news_type)){

                $status = '0';
                $news_record = News::where('news_paper_type',"=",$news_type)
                ->where('status',"=",$status)->where('news_date',"=",$date)
                ->first();

                if(empty($news_record)){
                    if($news_type=='1'){

                        $date_without_dash = str_replace('-', '', $date);
                        $word = $date_without_dash.'nstnews';
            
                        $targetfolder = 'app/public/news/nst/'.$date.'/main/images';
                        $targetfolder_cover = 'app/public/news/nst/'.$date.'/main/cover_photo';
                        if (!file_exists($targetfolder)) {
                            mkdir($targetfolder, 0777, true);
                        }
            
                        if (!file_exists($targetfolder_cover)) {
                            mkdir($targetfolder_cover, 0777, true);
                        }

                        $no_of_pages = 0;
                        for($i = 1; $i<=75; $i++) {
                            $image_url = "https://digital.nstp.com.my/nst/books/nstnews/$year/$word/images/pages/Page-$i.jpg";

                            //echo $image_url.'<br/>';
                            $save_as = "$targetfolder/$i.jpg";
                            $ch = curl_init($image_url);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                            $raw_data = curl_exec($ch);
                            $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                            curl_close($ch);
                            
                            if(empty($raw_data))
                            {
                                echo 'Empty Result';
                                die;
                            }else{
                                if ($response_status == 200) {
                                    if(file_exists($save_as)){
                                        unlink($save_as);
                                    }
                                    $image = Image::make($image_url);
                                    $image->save($save_as, 100);
                                    $no_of_pages = $i;
                                }else{
                                    break;
                                }

                                if($i=='1'){
                                    
                                    $save_as = "$targetfolder_cover/cover.jpg";
                                    if(file_exists($save_as)){
                                        unlink($save_as);
                                    }
                                    
                                    $image = Image::make($image_url);
                                    $image->save($save_as, 100);
                                    
                                }
                            }
                        }

                        $file_name = $date_without_dash.'_(NST)-Main';
                        $targetfolder_cover_ch = 'app/public/news/nst/'.$date.'/main/cover_photo';
                        $cover_photo = "$targetfolder_cover_ch/cover.jpg";
                        $db_file_name = "app/public/news/nst/$date/$file_name.pdf";
            
            
                        $news = new News;
                        $news->news_paper_type = '1';
                        $news->news_date = $date;
                        $news->cover_photo = $cover_photo;
                        $news->file_name = $db_file_name;
                        $news->no_of_pages = $no_of_pages;
                        $news->created_by = '1';
                        $news->created_at = $current_time;
                        $news->sequence = '1';
                        $news->save();

                         //Business Times
                        $word = $date_without_dash.'nstbusinesstimes';
                        $image_url = "https://digital.nstp.com.my/nst/books/nstbusinesstimes/$year/$word/images/pages/Page-1.jpg";
                        $ch = curl_init($image_url);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                        $raw_data = curl_exec($ch);
                        $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        if(empty($raw_data))
                        {
                            //die;
                        }else{
                            $targetfolder = 'app/public/news/nst/'.$date.'/businesstimes/images';
                            $targetfolder_cover = 'app/public/news/nst/'.$date.'/businesstimes/cover_photo';
                            if (!file_exists($targetfolder)) {
                                mkdir($targetfolder, 0777, true);
                            }
                
                            if (!file_exists($targetfolder_cover)) {
                                mkdir($targetfolder_cover, 0777, true);
                            }

                            $no_of_pages = 0;
                            for($i = 1; $i<=25; $i++) {
                    
                                    $image_url = "https://digital.nstp.com.my/nst/books/nstbusinesstimes/$year/$word/images/pages/Page-$i.jpg";
                                
                                    //echo $image_url.'<br/>';
                                    $save_as = "$targetfolder/$i.jpg";
                                    $ch = curl_init($image_url);
                                    curl_setopt($ch, CURLOPT_HEADER, false);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                                    $raw_data = curl_exec($ch);
                                    $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                    curl_close($ch);
                                    
                                    if(empty($raw_data))
                                    {
                                    
                                    }else{
                                        if ($response_status == 200) {
                                            if(file_exists($save_as)){
                                                unlink($save_as);
                                            }
                                            $image = Image::make($image_url);
                                            $image->save($save_as, 100);
                                            $no_of_pages = $i;
                                        }else{
                                            break;
                                        }

                                        if($i=='1'){
                                            
                                            $save_as = "$targetfolder_cover/cover.jpg";
                                            if(file_exists($save_as)){
                                                unlink($save_as);
                                            }
                                            
                                            $image = Image::make($image_url);
                                            $image->save($save_as, 100);
                                        
                                        }
                                    }
                                }

                            $file_name = $date_without_dash.'_(NST)-Business_Times';
                            $targetfolder_cover_ch = 'app/public/news/nst/'.$date.'/businesstimes/cover_photo';
                            $cover_photo = "$targetfolder_cover_ch/cover.jpg";
                            $db_file_name = "app/public/news/nst/$date/$file_name.pdf";

                            $news = new News;
                            $news->news_paper_type = '1';
                            $news->news_date = $date;
                            $news->cover_photo = $cover_photo;
                            $news->file_name = $db_file_name;
                            $news->no_of_pages = $no_of_pages;
                            $news->created_by = '1';
                            $news->created_at = $current_time;
                            $news->sequence = '1';
                            $news->save();
                        }

                        echo "Success";
                    }
                    if($news_type=='2'){
                       // create & initialize a curl session
                        $curl = curl_init();
                                            
                        // set our url with curl_setopt()
                        curl_setopt($curl, CURLOPT_URL, "https://newsstand.thestar.com.my/epaper/mobimax/mobimax_web.php?type=store&store_id=104&custid=4732&itemdate=$date&vc=1695056419769");
                        
                        // return the transfer as a string, also with setopt()
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        
                        // curl_exec() executes the started curl session
                        // $output contains the output string
                        $output = curl_exec($curl);
                        
                        // close curl resource to free up system resources
                        // (deletes the variable made by curl_init)
                        curl_close($curl);
                        
                        $output =  json_decode($output, true);
                        $books_list = $output['books'];
                        //print_r($books_list);
                        $have = '0';
                        foreach($books_list as $books){
                
                            $books_id = ($books['id']);
                            $books_cover_photo = ($books['cover']);
                            $books_title = ($books['title']);
                            $books_title = preg_replace('/[^A-Za-z0-9]/', '', $books_title);
            
                            if(!empty($books_id)){
            
                                $targetfolder = 'app/public/news/star/'.$date.'/'.$books_title.'/images';
                                $targetfolder_cover = 'app/public/news/star/'.$date.'/'.$books_title.'/cover_photo';
                                if (!file_exists($targetfolder)) {
                                    mkdir($targetfolder, 0777, true);
                                }
            
                                if (!file_exists($targetfolder_cover)) {
                                    mkdir($targetfolder_cover, 0777, true);
                                }
                                $no_of_pages = 0;
            
                                for($i = 1; $i<=75; $i++) {
                                    $image_url = "https://fireworksbucket.sgp1.cdn.digitaloceanspaces.com/epaper/mobimax/draft/$books_id/pages/large/$i.JPG";
            
                                    $save_as = "$targetfolder/$i.jpg";
                                    $ch = curl_init($image_url);
                                    curl_setopt($ch, CURLOPT_HEADER, false);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                                    $raw_data = curl_exec($ch);
                                    $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                    curl_close($ch);
            
                                    if(empty($raw_data))
                                    {
                                        echo 'Empty Result';
                                        die;
                                    }else{
                                        if ($response_status == 200) {
                                            if(file_exists($save_as)){
                                                unlink($save_as);
                                            }
                                            $image = Image::make($image_url);
                                            $image->resize(null, 1750, function ($constraint) {
                                                $constraint->aspectRatio();
                                                $constraint->upsize();
                                            });
                                            $image->save($save_as, 50);
                                            
                                            $no_of_pages = $i;
                                        }else{
                                            break;
                                        }
            
                                    }
                                }
            
                                $image_url = "https://fireworksbucket.sgp1.cdn.digitaloceanspaces.com/epaper/mobimax/draft/$books_id/covers/$books_id.JPG";
            
                                $save_as = "$targetfolder_cover/cover.jpg";
                                $ch = curl_init($image_url);
                                curl_setopt($ch, CURLOPT_HEADER, false);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                                $raw_data = curl_exec($ch);
                                $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                curl_close($ch);
            
                                if(file_exists($save_as)){
                                    unlink($save_as);
                                }
                                $image = Image::make($image_url);
                                $image->resize(null, 1750, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });
                                $image->save($save_as, 50);
                                
                                $date_without_dash = str_replace('-', '', $date);
                                //$file_name = $date.'_'.$books_title.'_star';
                                $file_name = $date_without_dash.'_(The_Star)-'.$books_title;
                                
                                $targetfolder_cover_ch = 'app/public/news/star/'.$date.'/'.$books_title.'/cover_photo';
            
                                $cover_photo = "$targetfolder_cover_ch/cover.jpg";
                                $db_file_name = "app/public/news/star/$date/$file_name.pdf";
                                $sequence = '1';
                           
                                $news = new News;
                                $news->news_paper_type = '2';
                                $news->news_date = $date;
                                $news->cover_photo = $cover_photo;
                                $news->file_name = $db_file_name;
                                $news->no_of_pages = $no_of_pages;
                                $news->created_by = '1';
                                $news->created_at = $current_time;
                                $news->sequence = '1';
                                $news->save();
                                $have++;
                                
                            }else{
                                echo "Empty Result";
                                die;
                            }
                        }

                        if($have > 0){
                            echo "Success";
                        }
                        /* $news_record_val = News::where('news_paper_type',"=",$newstype)
                        ->where('status',"=",$status)->where('news_date',"=",$date)
                        ->get(); */

                    }

                   
                }else{
                    echo "Exist";
                }

            }else{
                echo "Invalid";
            }
        }
    }

    
    public function nst(Request $request){

        //phpinfo();
        $now = Carbon::now();
        $today = $now->toDateString();
        $year =  $now->format('Y');
        $current_time = Carbon::now();
        $time = $now->format("H:i"); 

        $newstype = '1';
        $status = '0';
        $news_record = News::where('news_paper_type',"=",$newstype)
        ->where('status',"=",$status)->where('news_date',"=",$today)
        ->first();

        if(empty($news_record)){

            $date_without_dash = str_replace('-', '', $today);
            $word = $date_without_dash.'nstnews';

            $targetfolder = 'app/public/news/nst/'.$today.'/main/images';
            $targetfolder_cover = 'app/public/news/nst/'.$today.'/main/cover_photo';
            if (!file_exists($targetfolder)) {
                mkdir($targetfolder, 0777, true);
            }

            if (!file_exists($targetfolder_cover)) {
                mkdir($targetfolder_cover, 0777, true);
            }


            $no_of_pages = 0;
            for($i = 1; $i<=75; $i++) {

                $image_url = "https://digital.nstp.com.my/nst/books/nstnews/$year/$word/images/pages/Page-$i.jpg";

                //echo $image_url.'<br/>';
                $save_as = "$targetfolder/$i.jpg";
                $ch = curl_init($image_url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                $raw_data = curl_exec($ch);
                $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if(empty($raw_data))
                {
                    echo 'Empty Result';
                    die;
                }else{
                    if ($response_status == 200) {
                        if(file_exists($save_as)){
                            unlink($save_as);
                        }
                        $image = Image::make($image_url);
                        $image->save($save_as, 100);
                        $no_of_pages = $i;
                    }else{
                        break;
                    }

                    if($i=='1'){
                        
                        $save_as = "$targetfolder_cover/cover.jpg";
                        if(file_exists($save_as)){
                            unlink($save_as);
                        }
                        
                        $image = Image::make($image_url);
                        $image->save($save_as, 100);
                        
                    }
                }

            }

            $file_name = $date_without_dash.'_(NST)-Main';
            $targetfolder_cover_ch = 'app/public/news/nst/'.$today.'/main/cover_photo';
            $cover_photo = "$targetfolder_cover_ch/cover.jpg";
            $db_file_name = "app/public/news/nst/$today/$file_name.pdf";


            $news = new News;
            $news->news_paper_type = '1';
            $news->news_date = $today;
            $news->cover_photo = $cover_photo;
            $news->file_name = $db_file_name;
            $news->no_of_pages = $no_of_pages;
            $news->created_by = '1';
            $news->created_at = $current_time;
            $news->sequence = '1';
            $news->save();


            //Business Times
            $word = $date_without_dash.'nstbusinesstimes';
            $image_url = "https://digital.nstp.com.my/nst/books/nstbusinesstimes/$year/$word/images/pages/Page-1.jpg";
            $ch = curl_init($image_url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
            $raw_data = curl_exec($ch);
            $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
                
            if(empty($raw_data))
            {
                //die;
            }else{
            $targetfolder = 'app/public/news/nst/'.$today.'/businesstimes/images';
            $targetfolder_cover = 'app/public/news/nst/'.$today.'/businesstimes/cover_photo';
            if (!file_exists($targetfolder)) {
                mkdir($targetfolder, 0777, true);
            }

            if (!file_exists($targetfolder_cover)) {
                mkdir($targetfolder_cover, 0777, true);
            }
            $no_of_pages = 0;
            for($i = 1; $i<=25; $i++) {
    
                    $image_url = "https://digital.nstp.com.my/nst/books/nstbusinesstimes/$year/$word/images/pages/Page-$i.jpg";
                
                    //echo $image_url.'<br/>';
                    $save_as = "$targetfolder/$i.jpg";
                    $ch = curl_init($image_url);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                    $raw_data = curl_exec($ch);
                    $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    
                    if(empty($raw_data))
                    {
                    
                    }else{
                        if ($response_status == 200) {
                            if(file_exists($save_as)){
                                unlink($save_as);
                            }
                            $image = Image::make($image_url);
                            $image->save($save_as, 100);
                            $no_of_pages = $i;
                        }else{
                            break;
                        }

                        if($i=='1'){
                            
                            $save_as = "$targetfolder_cover/cover.jpg";
                            if(file_exists($save_as)){
                                unlink($save_as);
                            }
                            
                            $image = Image::make($image_url);
                            $image->save($save_as, 100);
                        
                        }
                    }
                }

                $file_name = $date_without_dash.'_(NST)-Business_Times';
                $targetfolder_cover_ch = 'app/public/news/nst/'.$today.'/businesstimes/cover_photo';
                $cover_photo = "$targetfolder_cover_ch/cover.jpg";
                $db_file_name = "app/public/news/nst/$today/$file_name.pdf";

                $news = new News;
                $news->news_paper_type = '1';
                $news->news_date = $today;
                $news->cover_photo = $cover_photo;
                $news->file_name = $db_file_name;
                $news->no_of_pages = $no_of_pages;
                $news->created_by = '1';
                $news->created_at = $current_time;
                $news->sequence = '1';
                $news->save();
            } 

            
            
        }

        $news_record_val = News::where('news_paper_type',"=",$newstype)
            ->where('status',"=",$status)->where('news_date',"=",$today)
            ->get();


            foreach ($news_record_val as $val) {
                $cover_photo = $val->cover_photo;
                $cover_exp = explode("/", $cover_photo);
                $sub_folder_name = $cover_exp[5];
                $file_name = $val->file_name;
                $file_exp = explode("/", $file_name);
                $ori_file_name = $file_exp[5];
    
                $images = [];
                foreach(glob("app/public/news/nst/$today/$sub_folder_name/images/*.*") as $file) {
                    $images[] = $file;
                }
                natsort($images);
    
                $pdf = new \Imagick($images);
                $pdf->setImageFormat('pdf');
                $pdf->writeImages("app/public/news/nst/$today/$ori_file_name", true);
                //Remove the Files
                $targetfolder = 'app/public/news/nst/'.$today.'/'.$sub_folder_name.'/images';
                File::deleteDirectory($targetfolder);
                //dd($images);
            }
    }

    public function Delete($path)
    {
        //dd($path);
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file)
            {
                Delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        }

        else if (is_file($path) === true)
        {
            return unlink($path);
        }

        return false;
    }

    public function star(Request $request){

        $now = Carbon::now();
        $today = $now->toDateString();
        $year =  $now->format('Y');
        $current_time = Carbon::now();
        $time = $now->format("H:i"); 

        $newstype = '2';
        $status = '0';
        $news_record = News::where('news_paper_type',"=",$newstype)
        ->where('status',"=",$status)->where('news_date',"=",$today)
        ->first();

        if(empty($news_record)){
            // create & initialize a curl session
            $curl = curl_init();
                                
            // set our url with curl_setopt()
            curl_setopt($curl, CURLOPT_URL, "https://newsstand.thestar.com.my/epaper/mobimax/mobimax_web.php?type=store&store_id=104&custid=4732&itemdate=$today&vc=1695056419769");
            
            // return the transfer as a string, also with setopt()
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
            // curl_exec() executes the started curl session
            // $output contains the output string
            $output = curl_exec($curl);
            
            // close curl resource to free up system resources
            // (deletes the variable made by curl_init)
            curl_close($curl);
            
            $output =  json_decode($output, true);
            $books_list = $output['books'];
            //print_r($books_list);
            $have = '0';
            foreach($books_list as $books){
                
                $books_id = ($books['id']);
                $books_cover_photo = ($books['cover']);
                $books_title = ($books['title']);
                $books_title = preg_replace('/[^A-Za-z0-9]/', '', $books_title);

                if(!empty($books_id)){

                    $targetfolder = 'app/public/news/star/'.$today.'/'.$books_title.'/images';
                    $targetfolder_cover = 'app/public/news/star/'.$today.'/'.$books_title.'/cover_photo';
                    if (!file_exists($targetfolder)) {
                        mkdir($targetfolder, 0777, true);
                    }

                    if (!file_exists($targetfolder_cover)) {
                        mkdir($targetfolder_cover, 0777, true);
                    }
                    $no_of_pages = 0;

                    for($i = 1; $i<=75; $i++) {
                        $image_url = "https://fireworksbucket.sgp1.cdn.digitaloceanspaces.com/epaper/mobimax/draft/$books_id/pages/large/$i.JPG";

                        $save_as = "$targetfolder/$i.jpg";
                        $ch = curl_init($image_url);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                        $raw_data = curl_exec($ch);
                        $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        if(empty($raw_data))
                        {
                            echo 'Empty Result';
                            die;
                        }else{
                            if ($response_status == 200) {
                                if(file_exists($save_as)){
                                    unlink($save_as);
                                }
                                $image = Image::make($image_url);
                                $image->resize(null, 1750, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });
                                $image->save($save_as, 50);
                                
                                $no_of_pages = $i;
                            }else{
                                break;
                            }

                        }
                    }

                    $image_url = "https://fireworksbucket.sgp1.cdn.digitaloceanspaces.com/epaper/mobimax/draft/$books_id/covers/$books_id.JPG";

                    $save_as = "$targetfolder_cover/cover.jpg";
                    $ch = curl_init($image_url);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
                    $raw_data = curl_exec($ch);
                    $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if(file_exists($save_as)){
                        unlink($save_as);
                    }
                    $image = Image::make($image_url);
                    $image->resize(null, 1750, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $image->save($save_as, 50);
                    
                    $date_without_dash = str_replace('-', '', $today);
                    //$file_name = $date.'_'.$books_title.'_star';
                    $file_name = $date_without_dash.'_(The_Star)-'.$books_title;
                    
                    $targetfolder_cover_ch = 'app/public/news/star/'.$today.'/'.$books_title.'/cover_photo';

                    $cover_photo = "$targetfolder_cover_ch/cover.jpg";
                    $db_file_name = "app/public/news/star/$today/$file_name.pdf";
                    $sequence = '1';
               
                    $news = new News;
                    $news->news_paper_type = '2';
                    $news->news_date = $today;
                    $news->cover_photo = $cover_photo;
                    $news->file_name = $db_file_name;
                    $news->no_of_pages = $no_of_pages;
                    $news->created_by = '1';
                    $news->created_at = $current_time;
                    $news->sequence = '1';
                    $news->save();
                    $have++;
                    
                }else{
                    echo "Empty Result";
                    die;
                }
            }

            $news_record_val = News::where('news_paper_type',"=",$newstype)
            ->where('status',"=",$status)->where('news_date',"=",$today)
            ->get();

            foreach ($news_record_val as $val) {
                $cover_photo = $val->cover_photo;
                $cover_exp = explode("/", $cover_photo);
                $sub_folder_name = $cover_exp[5];
                $file_name = $val->file_name;
                $file_exp = explode("/", $file_name);
                $ori_file_name = $file_exp[5];
    
                $images = [];
                foreach(glob("app/public/news/star/$today/$sub_folder_name/images/*.*") as $file) {
                    $images[] = $file;
                }
                natsort($images);
    
                $pdf = new \Imagick($images);
                $pdf->setImageFormat('pdf');
                $pdf->writeImages("app/public/news/star/$today/$ori_file_name", true);

                //Remove the Files
                $targetfolder = 'app/public/news/star/'.$today.'/'.$sub_folder_name.'/images';
                File::deleteDirectory($targetfolder);

            }
        }

    }


    public function deleterec(Request $request){
        $date = $request->date;
        $type = $request->type;
        $ecrp = $request->ecrp;

        $current_time = Carbon::now();

        if(!empty($ecrp) && !empty($type)){
            if($type=='nst'){

                $news_paper_type = '1';
                $status = '0';

                $news_record_val = News::where('news_paper_type',"=",$news_paper_type)
                ->where('status',"=",$status)->where('news_date',"=",$date)
                ->get();


                foreach ($news_record_val as $val) {
                    $file_id = $val['id'];

                    $new_status = '1';
                    $news = News::find($file_id);
                    $news->deleted_by = "1";
                    $news->deleted_at = $current_time;
                    $news->status = $new_status;
                    $news->save();
                }
                
                $targetfolder = 'app/public/news/nst/'.$date;
                File::deleteDirectory($targetfolder);

                echo "Success";

            }

            if($type=='star'){

                $news_paper_type = '2';
                $status = '0';

                $news_record_val = News::where('news_paper_type',"=",$news_paper_type)
                ->where('status',"=",$status)->where('news_date',"=",$date)
                ->get();

                foreach ($news_record_val as $val) {
                    $file_id = $val['id'];

                    $new_status = '1';
                    $news = News::find($file_id);
                    $news->deleted_by = "1";
                    $news->deleted_at = $current_time;
                    $news->status = $new_status;
                    $news->save();
                }

                $targetfolder = 'app/public/news/star/'.$date;
                File::deleteDirectory($targetfolder);

                echo "Success";

            }

            if($type=='ozark'){
                $news_record_val = News::where('id',"=",$ecrp)->get();
                foreach ($news_record_val as $val) {
                    $file_name = $val['file_name'];
                    if(!empty($file_name)){
                        $file_name = explode('/', $file_name);
                        $url_val = $file_name['4'];
                        $targetfolder = 'app/public/news/ozark/'.$url_val;
                        File::deleteDirectory($targetfolder);
                        //File::delete($targetfolder);

                    }
                }

                $new_status = '1';
                $news = News::find($ecrp);
                $news->deleted_by = "1";
                $news->deleted_at = $current_time;
                $news->status = $new_status;
                $news->save();

                echo "Success";
            }
        }
    }

    public function deletemultiprec(Request $request){
        $ids = $request->id;

        $current_time = Carbon::now();
        if(!empty($ids)){
            foreach($ids as $id){

                $news_records = News::where('id',"=",$id)->first();
                $news_paper_type = $news_records->news_paper_type;
                $file_id = $news_records->id;
                $news_date = $news_records->news_date;
                $file_name = $news_records->file_name;

                if($news_paper_type == '1'){

                    $status = '0';
                    $news_record_val = News::where('news_paper_type',"=",$news_paper_type)
                    ->where('status',"=",$status)->where('news_date',"=",$news_date)
                    ->get();
                    
                    foreach ($news_record_val as $val) {
                        $file_id = $val['id'];

                        $new_status = '1';
                        $news = News::find($file_id);
                        $news->deleted_by = "1";
                        $news->deleted_at = $current_time;
                        $news->status = $new_status;
                        $news->save();
                    }

                    $targetfolder = 'app/public/news/nst/'.$news_date;
                    File::deleteDirectory($targetfolder);

                }

                if($news_paper_type == '2'){

                    $status = '0';
                    $news_record_val = News::where('news_paper_type',"=",$news_paper_type)
                    ->where('status',"=",$status)->where('news_date',"=",$news_date)
                    ->get();

                    foreach ($news_record_val as $val) {
                        $file_id = $val['id'];

                        $new_status = '1';
                        $news = News::find($file_id);
                        $news->deleted_by = "1";
                        $news->deleted_at = $current_time;
                        $news->status = $new_status;
                        $news->save();
                    }

                    $targetfolder = 'app/public/news/star/'.$news_date;
                    File::deleteDirectory($targetfolder);

                }

                if($news_paper_type == '3'){
                    if(!empty($file_name)){

                        $file_name = explode('/', $file_name);
                        $url_val = $file_name['4'];
                        $targetfolder = 'app/public/news/ozark/'.$url_val;
                        File::deleteDirectory($targetfolder);
                        
                    }

                    $new_status = '1';
                    $news = News::find($file_id);
                    $news->deleted_by = "1";
                    $news->deleted_at = $current_time;
                    $news->status = $new_status;
                    $news->save();
                }
                
            }
            echo 'Success';
        }else{
            echo 'Invalid';
        }
    }

    public function newsData(){
        $now = Carbon::now();
        $today = $now->toDateString();

        $newdatas = DB::select("SELECT MAX(news.id) as newsid, news.news_date, news.news_paper_type, MAX(news.cover_photo) as cover_photo, MAX(news.no_of_pages) as no_of_pages, MAX(news.file_name) as file_name FROM news WHERE status = '0' 
        GROUP BY news.news_date, news_paper_type, news.sequence ");
        //dd($newdatas);
        $record = array();
        foreach($newdatas as $datas){
            $id = $datas->newsid;
            $news_date = $datas->news_date;
            $news_paper_type = $datas->news_paper_type;
            $no_of_pages = $datas->no_of_pages; 
            $file_name = $datas->file_name; 
            $cover_photo = $datas->cover_photo;

            if($news_paper_type != '3'){

                $news_pic_rec = DB::select("SELECT * FROM `news` WHERE news_paper_type = $news_paper_type AND status = '0' AND DATE(`news_date`) = '$news_date'");
                //DD($news_pic_rec[0]->cover_photo);
                $cover_pic = array();
                foreach($news_pic_rec as $news_pic){
                    $cover_photo = $news_pic->cover_photo;
                    $file_name = $news_pic->file_name;
                    if(!empty($cover_photo)){
                        $cover_pic[] = '<a href="'.$file_name.'" target=_blank><img src="'.$cover_photo.'" alt="" width="150" height="200"></a>';
                    }
                }
                 //return $cover_pic;
        
            }else{
                $news_pic_rec = DB::select("SELECT * FROM `news` WHERE id = $id AND status = '0'");

                foreach($news_pic_rec as $news_pic){
                    $cover_photo = $news_pic->cover_photo;
                    $file_name = $news_pic->file_name;
                    $cover_pic = array();
                    if(!empty($cover_photo)){
                        $cover_pic[] = '<a href="'.$file_name.'" target=_blank><img src="'.$cover_photo.'" alt="" width="150" height="200"></a>';
                    }
                }
            }

            if($news_paper_type=='1'){
                $paper_type = 'NST';
                $b4_news_date = $news_date;
                $btn = '<button type="button" class="btn btn-danger btn-xs" onclick="deleteRow(\''.$id.'\',\'nst\', \''.$b4_news_date.'\')" >DELETE</button>';

            }
            if($news_paper_type=='2'){
                $paper_type = 'STAR';
                $b4_news_date = $news_date;
                $btn = '<button type="button" class="btn btn-danger btn-xs" onclick="deleteRow(\''.$id.'\',\'star\', \''.$b4_news_date.'\')" >DELETE</button>';

            }
            if($news_paper_type=='3'){
                $paper_type = 'ISSUU';
                $b4_news_date = '';
                $btn = '<button type="button" class="btn btn-danger btn-xs" onclick="deleteRow(\''.$id.'\',\'ozark\', \''.$today.'\')" >DELETE</button>';

            }

            $record[] = array('id' => $id, 'news_date' => $news_date, 'news_paper_type' => $paper_type, 'cover_pic' => $cover_pic, 'action' => $btn);
        }

        return Datatables::of($record)->escapeColumns([])
        ->make(true);
    }



}
