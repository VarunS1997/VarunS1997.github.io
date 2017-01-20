<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Archives | Varun Singh</title>

    <?php include "modules/std-config.html"; ?>

    <script>
        function replaceImage(elem){
            elem.src = "image-assets/project-images/image-error.png";
        }
    </script>

    <style type="text/css">
    .container:first-child{
        padding-bottom: 0px;
    }

    .container:nth-child(2){
        padding-top: 0px;
    }
    </style>
</head>
<body onload="initResponsive();">
    <?php include "modules/page-header.php"; ?>
    <div class="wrapper" id="body-wrapper">
        <div class="container">
            <span class="section-title title">Just a few of my thoughts:</span>
        </div>
        <?php
        libxml_use_internal_errors(true);

        $data = simplexml_load_file("XMLData/thoughts.xml");
        $error = false;

        if($data == false){
            $error = true;

            //TODO Consider better debugging?
            echo "An Error Occured";
        } else {
            $dataCount = $data->count();
            for($i = 0; $i < $dataCount; $i++){
                echo "
                <div class='inline-row'>
                <div class='container'>
                <div class='text-container'>
                <p>";

                echo "
                <span class='title'><a target='_blank' href='" . $data->project[$i]->url . "'>" . $data->project[$i]->name . "</a></span>" . $data->project[$i]->description;

                echo "</p>
                </div>"; // close text-container
                echo "<div class='image-container'>
                <a target='_blank' href='" . $data->project[$i]->url . "'>
                <img style='" .
                ($data->project[$i]->backgroundColor != "" ?
                ("background-color: " . $data->project[$i]->backgroundColor) : "")
                . "' onerror='replaceImage(this);' src='" . $data->project[$i]->iconSource . "' alt='" . $data->project[$i]->name . "'/>
                </a>
                </div>";
                echo "</div></div>"; // close container and row
            }
        }
        ?>
    </div>
    <?php
    include "modules/footer.php";
    ?>
</body>
</html>
