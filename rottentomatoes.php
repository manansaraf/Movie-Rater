<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// Free PHP Rotten Tomatoes Scraping API
// Version: 2.3
// Author: Abhinay Rathore
// Website: http://www.AbhinayRathore.com
// Blog: http://web3o.blogspot.com
// Demo: http://lab.abhinayrathore.com/rottentomatoes/
// More Info: http://web3o.blogspot.com/2011/01/free-php-rotten-tomatoes-scraping-api.html
// Last Updated: May 10, 2012
/////////////////////////////////////////////////////////////////////////////////////////////////////////
 
class RottenTomatoes
{
    function getMovieInfo($title)
    {
        $rottentomatoesUrl = $this->getRottenTomatoesUrlFromGoogle($title);
        if ($rottentomatoesUrl === NULL) { return NULL; }
        $html = $this->geturl($rottentomatoesUrl);
        $arr = array();
        $arr = $this->scrapMovieInfo($html);
        return $arr;
    }
     
    function getRottenTomatoesUrlFromGoogle($title){
        $url = "http://www.google.com/search?q=RottenTomatoes.com+" . rawurlencode($title);
        $html = $this->geturl($url);
        $rottentomatoesurls = $this->match_all('/<a href="(http:\/\/www.rottentomatoes.com\/m\/.*?)".*?>.*?<\/a>/ms', $html, 1);
        if (!isset($rottentomatoesurls[0]))
            return $this->getRottenTomatoesUrlFromBing($title); //search using Bing
        else
            return $rottentomatoesurls[0]; //return first Rotten Tomatoes result
    }
     
    function getRottenTomatoesUrlFromBing($title){
        $url = "http://www.bing.com/search?q=RottenTomatoes.com+" . rawurlencode($title);
        $html = $this->geturl($url);
        $rottentomatoesurls = $this->match_all('/<a href="(http:\/\/www.rottentomatoes.com\/m\/.*?)".*?>.*?<\/a>/ms', $html, 1);
        if (!isset($rottentomatoesurls[0]))
            return NULL;
        else
            return $rottentomatoesurls[0]; //return first Rotten Tomatoes result
    }
     
    // Scan movie data from Rotten Tomatoes page
    function scrapMovieInfo($html)
    {
        $arr = array();
        $arr['title'] = trim(strip_tags($this->match('/<h1 class="movie_title">(.*?) \(\d{4}\)<\/span>/ms', $html, 1)));
        $arr['year'] = trim($this->match('/<h1 class="movie_title">.*? \((\d{4})\)<\/span>/ms', $html, 1));
        $arr['poster'] = str_replace("_tmb.jpg", "_ori.jpg", trim($this->match('/<input name="posterUrl".*?value="(.*?)"/ms', $html, 1)));
        $arr['all_critics_percentage'] = trim($this->match('/id="all-critics-meter".*?>([0-9]*?)<\/span>/ms', $html, 1));
        $arr['all_critics_average_rating'] = trim($this->match('/Average Rating: <span>([0-9]?\.?[0-9]?)\/10<\/span>/ms', $html, 1));
        $arr['all_critics_count'] = trim($this->match('/reviewCount">(\d*?)<\/span>/ms', $html, 1));
        $arr['user_percentage'] = trim($this->match('/<span class="meter popcorn numeric ">([0-9]*?)<\/span>/ms', $html, 1));
        $arr['user_average_rating'] = trim($this->match('/Average Rating: ([0-9]?\.?[0-9]?)\/5<br\/>/ms', $html, 1));
        $arr['user_count'] = trim($this->match('/User Ratings: (.*?)\s*?<\/p>/ms', $html, 1));
        $arr['genres'] = array();
        foreach($this->match_all('/"genre">(.*?)<\/span>/ms', $html, 1) as $m)
            array_push($arr['genres'], $m);
        $arr['synopsis'] = trim(strip_tags($this->match('/itemprop="description">(.*?)<\/span>/ms', $html, 1)));
        $arr['mpaa_rating'] = trim($this->match('/itemprop="contentRating">(.*?)<\/span>/ms', $html, 1));
        $arr['runtime'] = trim($this->match('/content="162">(.*?)<\/span>/ms', $html, 1));
        $arr['release_date'] = trim($this->match('/itemprop="datePublished".*?>(.*?)<\/span>/ms', $html, 1));
        $arr['box_office'] = trim($this->match('/Box Office:<\/label><span class="content">(.*?)<\/span>/ms', $html, 1));
        $arr['directors'] = array();
        foreach($this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Directed By:(.*?)<\/p>/ms', $html, 1), 1) as $m)
            array_push($arr['directors'], trim(strip_tags($m)));
        $arr['writers'] = array();
        foreach($this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Written By:(.*?)<\/p>/ms', $html, 1), 1) as $m)
            array_push($arr['writers'], trim(strip_tags($m)));
        $arr['cast'] = array();
        foreach($this->match_all('/itemprop="name">(.*?)<\/span>/ms', $this->match('/<h3>Cast<\/h3>(.*?)body>/ms', $html, 1), 1) as $m)
            array_push($arr['cast'], $m);
        $arr['cast'] = array_slice($arr['cast'], 0, 20);
        $arr['reviews'] = array();
        foreach($this->match_all('/<div class="review_quote">(.*?)<div class="quote_bubble/ms', $html, 1) as $m){
            $review = trim($this->match('/<p>(.*?)<\/p>/ms', $m, 1));
            $reviewer = trim(strip_tags($this->match('/<a href="\/critic\/.*?>(.*?)<\/a>/ms', $m, 1)));
            $reviewsource = trim(strip_tags($this->match('/<a target="_blank" class="italic".*?>(.*?)<\/a>/ms', $m, 1)));
            if($reviewsource == '') $reviewsource = trim(strip_tags($this->match('/<div class="subtle italic">(.*?)<\/div>/ms', $m, 1)));
            $review = $review . ' [' . $reviewer . ' - ' . $reviewsource . ']';
            array_push($arr['reviews'], $review);
        }
        return $arr;
    }
     
    // Scan newly released DVD pages on Rottem Tomatoes
    function getNewDvdReleases()
    {
        $url  = "http://www.rottentomatoes.com/dvd/new_releases.php";
        $arr = array();
        for($p = 1; $p <= 4; $p++){
            $html = $this->geturl($url . "?page=" . $p);
            foreach($this->match_all('/media_block_content(.*?)Trailer/ms', $html, 1) as $m)
            {
                $name = trim(strip_tags($this->match('/<h2>.*?<a.*?>(.*?)<\/a>.*?<\/h2>/ms', $m, 1)));
                $date = trim(strip_tags($this->match('/<div class="subtle">(.*?)—/ms', $m, 1)));
                array_push($arr, array("name" => $name, "date" => $date));
            }
        }
        return $arr;
    }
     
    // ************************[ Extra Functions ]******************************
    function geturl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1");
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }
 
    function match_all($regex, $str, $i = 0)
    {
        if(preg_match_all($regex, $str, $matches) === false)
            return false;
        else
            return $matches[$i];
    }
 
    function match($regex, $str, $i = 0)
    {
        if(preg_match($regex, $str, $match) == 1)
            return $match[$i];
        else
            return false;
    }
}
?>