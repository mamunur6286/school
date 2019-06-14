<?php require "includes/header.php"; ?>

    <!--Slider-->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block img-fluid w-100" src="<?php echo $up_img_path.$setting['slider_image_1']; ?>" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid w-100" src="<?php echo $up_img_path.$setting['slider_image_2']; ?>" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid w-100" src="<?php echo $up_img_path.$setting['slider_image_3']; ?>" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!--Box menu-->
    <div class="card-body">
        <div class="row box-wrapper">
            <div class="col-md-10 offset-md-1">
                <div class="row text-center py-1">
                    <div class="col-md-3 col-sm-3 box-menu">
                        <a href="main-calendar">
                            <img src="img/calendar-icon.png" height="80">
                            <h5 class="text-light">Main Calendar</h5>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-3 box-menu">
                        <a href="student-books">
                            <img src="img/student-books-icon.png" height="80">
                            <h5 class="text-light">Student Books</h5>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-3 box-menu">
                        <a href="student-class-routine">
                            <img src="img/class-routine-icon.png" height="80">
                            <h5 class="text-light">Routine</h5>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-3 box-menu">
                        <a href="student-info-for-result">
                            <img src="img/exam-result-icon.png" class="mt-1" height="80">
                            <h5 class="text-light">Result</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Welcome section-->
    <div class="row mt-3">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center welcome">WELCOME</h1>
            <hr>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-10 offset-md-1">
            <h5 class="text-center">
                <?php echo $setting['welcome_messege']; ?>
            </h5>
        </div>
    </div>


    <div class="row mt-4">

        <!-- Principle Message -->
        <div class="col-md-6 card-body border-right">
            <h2 class="headline">MESSAGE FROM PRINCIPLE</h2>

            <p class="text-center"><img src="<?php echo $up_img_path.$setting['principle_image']; ?>" height="200"></p>
            <div class="card-body">
                <p class="card-text text-justify p-1" style="height: 200px; overflow: scroll; overflow-x: unset;">
                    <?php echo $setting['principle_message']; ?>
                </p>
            </div>

        </div>

        <!-- School Notices -->
        <div class="col-md-6 card-body border-left">
            <h2 class="headline">SCHOOL NOTICES</h2>
            <marquee direction="up" onmouseout="this.setAttribute('scrollamount', 4, 0);"
                     onmouseover="this.setAttribute('scrollamount', 0, 0);"
                     scrollamount="2" height="60%">
                <?php
                $latestNotice = $school->getLatestNotice();
                if (!empty($latestNotice)) {
                    foreach ($latestNotice as $notice) {
                        ?>
                        <a href="single_notice?n=<?php echo $notice['id']; ?>" class="text-dark"
                           style="text-decoration: none;">
                            <div class="row mb-3 mr-1 ml-1">
                                <div class="col-3 text-center box-wrapper text-uppercase">
                                    <?php
                                    $date = strtotime($notice['publish_date']);
                                    echo date('D, M', $date) . "<br> <strong>" . date(' d', $date) . "</strong> <br>";
                                    echo date('Y', $date);
                                    ?>
                                </div>
                                <div class="col-9 border font-weight-bold">
                                    <?php echo $notice['title']; ?>
                                </div>
                            </div>
                        </a>
                    <?php }
                } ?>
            </marquee>
            <br><br><br>
            <h6 class="text-center"><a href="all-notice">SEE MORE NOTICE</a></h6>
        </div>
    </div>

    <!-- fixed background-1 box -->
    <div class="fixed-background-1">
        <p>
            <span>
                The mission of <?php echo $setting['school_name']; ?> is to provide all students with dynamic
                learning opportunities in a nurturing environment, inspiring life-long
                learning and the realization of full potential.
            </span>
        </p>
    </div>


    <div class="row mt-4 mb-5">

        <!-- Complaint Box -->
        <div class="col-md-5 card-body">
            <h2 class="headline">Complaint Box</h2><br>
            <a href="complain-box">
                <img src="img/complaint-box.jpg" class="img-fluid">
            </a>
        </div>

        <div class="col-md-1 border-right"></div>

        <!-- Useful Links -->
        <div class="col-md-6 card-body quick-links">
            <h2 class="headline">Quick Links</h2><br>

            <div class="quick-links-inner">
                <p class="ml-4">
                    <i class="fa fa-hand-o-right"></i>
                    <a href="https://moedu.gov.bd/" target='_blank'>Ministry Of Education</a>
                </p>
                <p class="ml-4">
                    <i class="fa fa-hand-o-right"></i>
                    <a href="http://www.educationboardresults.gov.bd/" target='_blank'>Education Board Result</a>
                </p>
                <p class="ml-4">
                    <i class="fa fa-hand-o-right"></i>
                    <a href="https://sylhetboard.gov.bd/" target='_blank'>Sylhet Education Board</a>
                </p>
                <p class="ml-4">
                    <i class="fa fa-hand-o-right"></i>
                    <a href="www.rajshahieducationboard.gov.bd/" target='_blank'>Rajshahi Education Board</a>
                </p>
                <p class="ml-4">
                    <i class="fa fa-hand-o-right"></i>
                    <a href="comillaboard.portal.gov.bd/" target='_blank'>Comilla Board</a>
                </p>
                <p class="ml-4">
                    <i class="fa fa-hand-o-right"></i>
                    <a href="www.dinajpureducationboard.gov.bd/" target='_blank'>Dinajpur Education Board</a>
                </p>
            </div>
            
        </div>

    </div>

    <!-- Second nav -->
    <div class="col-md-10 offset-md-1 second-nav-main">
        <ul class="second-nav">
            <li><a href="home">HOME</a></li>
            <li><a href="about">ABOUT</a></li>
            <li><a href="gallery">GALLERY</a></li>
            <li><a href="contact">CONTACT</a></li>
            <li><a href="all-notice">NOTICE BOARD</a></li>
            <li><a href="student-info-for-result">RESULT</a></li>
            <li><a href="teacher-list">TEACHERS</a></li>
            <li><a href="student-class-routine">ROUTINE</a></li>
            <li><a href="online-apply-for-addmission">ONLINE APPLY</a></li>
        </ul>
    </div>

    <div class="row card-body mt-5">
        <div class="col-md-2">
            <img src="<?php echo $up_img_path.$setting['school_image']; ?>" class="img-fluid">
        </div>
        <div class="col-md-10">
            <h3><?php echo $setting['school_name']; ?></h3>
            <p><?php echo $setting['school_address']; ?></p>
            <p>Phone - <?php echo $setting['school_phone']; ?> • Email - <?php echo $setting['school_email']; ?></p>
        </div>
    </div>

<?php require "includes/footer.php"; ?>