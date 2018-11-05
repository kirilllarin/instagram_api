<?php

include 'vendor/autoload.php';

try {
    \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

    $ig = new \InstagramAPI\Instagram(false);

    //$ig->setProxy('http://127.0.0.1:80');

    $ig->_setUser('lapinmax2', '08-04-90ml');

//    $response = $ig->people->getInfoById($userId);
//    echo $response->getUser()->getUsername();
//
//    var_dump($response);exit;

    $feed = $ig->timeline->getTimelineFeed()->asArray();

} catch (Exception $e) {

    echo $e->getMessage();
}


?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Instagram</title>
</head>
<style>
  h6{
    margin-left: 40px
  }
  img.avatar{
    width: 30px
  }
  .text{
    margin-top: 10px;
  }
</style>
<body>
<div class="container">
    <?php if (isset($feed['feed_items'])) { ?>
        <?php foreach ($feed['feed_items'] as $item) : ?>
            <?php if (isset($item['media_or_ad'])) { ?>
          <div class="col-md-10 mt-5 mb-3">
            <img class="float-left avatar" src="<?php echo $item['media_or_ad']['user']['profile_pic_url']; ?>" alt="">
            <h6><?php echo $item['media_or_ad']['user']['username']; ?></h6>
            <div class="col pt-3">
                <?php if (isset($item['media_or_ad']['carousel_media'])) { ?>
                    <?php foreach ($item['media_or_ad']['carousel_media'] as $media) : ?>
                        <?php if (isset($media['image_versions2'])) { ?>
                      <img src="<?php echo $media['image_versions2']['candidates'][1]['url']; ?>" alt="">
                        <?php } ?>
                    <?php endforeach; ?>
                <?php } ?>
                <?php if (isset($item['media_or_ad']['image_versions2'])) { ?>
                  <img src="<?php echo $item['media_or_ad']['image_versions2']['candidates'][1]['url']; ?>" alt="">
                <?php } ?>
            </div>
            <div class="col-md-10 text">
              <p class="col"><?php echo $item['media_or_ad']['caption']['text']; ?></p>
            </div>
            <div class="col">
                <?php
                $comments = $ig->media->getComments($item['media_or_ad']['caption']['media_id'])->asArray();
                if (isset($comments['comments'])&& $comments['comments']) {
                    ?>
                  <strong class="col">Comments:</strong>
                    <?php
                    foreach ($comments['comments'] as $comment) {
                        echo '<p>' . $comment['user']['username'] . ': ' . $comment['text'] . '</p>';
                    }
                }
                ?>
            </div>
          </div>
            <?php } ?>
        <?php endforeach ?>
    <?php } ?>
</div>
</body>
</html>
