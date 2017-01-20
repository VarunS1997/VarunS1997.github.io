<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Home | Varun Singh</title>

    <?php include "modules/std-config.html"; ?>
    <style type="text/css">
    /* HOMEPAGE CSS */
    .branding-container{
        padding: 20px 0px 10px;
        background-color: rgba(0, 0, 0, 1);
    }

    .branding-container span{
        color: rgb(255, 255, 255);
    }

    .branding-container span.section-title{
        width: 650px;
        margin: 0px auto;
        border-color: rgb(255, 255, 255);
    }

    .super-title{
        font-size: 60px !important; /* Override .title */
    }

    ul#navBar{
        margin-top: 5px;
    }

    #homeWrapper{
        height: 300px;
        padding: 50px 0px;
        background-color: rgb(0, 0, 0);
    }

    #homeContainer{
        color: rgb(255, 255, 255);
        font-weight: bold;
    }

    #homeContainer a{
        color: rgb(115, 190, 255);
    }

    #homeContainer a:hover{
        color: rgb(145, 220, 255);
    }
    </style>
</head>
<body onload="initResponsive()">
    <div id="page-header-wrapper" class="wrapper">
        <div class="branding-container">
            <span class="title super-title">Varun Singh</span>
            <span class="section-title title">Coder. Problem-Solver. Geek.</span>
            <ul class="inline-list" id="navBar">
                <li><a href="archives">Project Archives</a></li>
                <li><a target="_blank" href="resume.pdf">Online Resume</a></li>
                <li><a href="contact">Contact Me</a></li>
            </ul>
        </div>
    </div>
    <div id="homeWrapper" class="wrapper">
        <div id="homeContainer" class="container">
            <div class="text-container">
                <p>
                    Hi. I'm Varun.
                    <br /><br />
                    I make things work. I take pleasure in difficult problems and pride in my solutions. Consulting, development, or teaching, you name it, I do it.
                    <br /><br />
                    I let my work speak for me. So, take a look around; maybe we'll <a href="contact.php">build your next project together.</a>
                </p>
            </div>
        </div>
    </div>
    <div class="wrapper" id="body-wrapper">
        <div class="container">
            <span class="section-title title">My Most Recent Project</span>
            <div class="inline-row">
                <div class="text-container">
                    <p>
                        <?php
                        libxml_use_internal_errors(true);

                        $data = simplexml_load_file("XMLData/projects.xml");
                        $error = false;

                        if($data == false){
                            $error = true;

                            //TODO Consider better debugging?
                            echo "An Error Occured";
                        } else {
                            echo "
                            <span class='title'><a target='_blank' href='" . $data->project[0]->url . "'>" . $data->project[0]->name . "</a></span>" . $data->project[0]->description;
                        }
                        ?>
                    </p>
                </div>
                <div class="image-container">
                    <?php if(!$error){
                        echo "<a target='_blank' href='" . $data->project[0]->url . "'><img src='" . $data->project[0]->iconSource . "'/></a>";
                    }?>
                </div>
            </div>
            <div class="inline-row">
                Take a look at <a href="archives.php">my other projects</a>, too!
            </div>
        </div>
    </div>
    <?php
    include "modules/footer.php";
    ?>
</body>
</html>
