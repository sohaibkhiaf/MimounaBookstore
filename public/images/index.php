<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/mimouna-2.jpg">
    <title>مكتبة ميمونة - بوابتك لعالم المطالعة والمعرفة</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">

</head>
<body>

    <!-- ------------------------------------------- header + navigation --------------------------------------- -->

    <?php 
        
        require_once "templates/connection.php"; //  $database , $url

        if($database){

            session_start();

            // validate token
            require_once "templates/validtoken.php";

            ///////////////////////////////////////// check if account is activated or not ///////////////////////////////
            if(isset($_SESSION['email'])){
                if($_SESSION['activated'] == 0){
                    echo '<div class="red-message">قم بتأكيد بريدك الإلكتروني عن طريق فتح الرابط الذي قمنا بإرساله لك، <a href="index.php?activated=-1">إعادة إرسال بريد التحقق</a></div>';
                }
            }

            ////////////////////////////// when user is activating their account //////////////////////////////////////
            if(isset($_GET['activated'])){

                if($_GET['activated'] == 1){ // account activated 
                    echo '<div class="green-message">تم التحقق من حسابك بنجاح</div>';
                }elseif($_GET['activated'] == 0){ // account not activated 
                    echo '<div class="red-message">رمز التحقق غير صالح</div>';
                }elseif($_GET['activated'] == -1){ // resend activate email

                    $getCode = $database->prepare("SELECT SecCode FROM Users WHERE UserID = :USER_ID;");
                    $getCode->bindParam("USER_ID",$_SESSION['userid']);
                    
                    if($getCode->execute()){
                        $code = $getCode->fetch(PDO::FETCH_ASSOC);

                        // send confirmation mail
                        require_once "mail.php";
                        $mail->addAddress($_SESSION['email']);
                        $mail->Subject = "رمز التحقق من بريدك الإلكتروني";
                        $mail->Body = "<h2>شكرا لتسجيلك في مكتبتنا</h2><div>رابط التحقق من الحساب</div><a href='".$url."activate.php?code=".$code['SecCode']."'>".$url."activate.php</a>";
                        $mail->setFrom("mimounabookstore@support.com" , "Mimouna Bookstore");
                        $mail->send();
                        echo '<div class="green-message">لقد قمنا بإرسال بريد التحقق إلى بريدك الإلكتروني</div>';
                    }
                    
                }
            }

            //////////////////////////////////// when user resets their password /////////////////////////////////////
            if(isset($_GET['reset'])){
                if($_GET['reset'] == 1){
                    echo '<div class="green-message">لقد قمت بتغيير كلمة المرور الخاصة بك بنجاح، يمكنك الآن القيام بتسجيل الدخول</div>';
                }elseif($_GET['reset'] == 0){
                    echo '<div class="red-message">رمز التحقق غير صالح</div>';
                }elseif($_GET['reset'] == -1){
                    echo '<div class="red-message">كلمات المرور الخاصة بك غير صالحة أو قمت بإدخال كلمات مرور غير متطابقة</div>';
                }
            }


            // inclute templates
            require_once "templates/auth.php";
            require_once "templates/header.php";
            require_once "templates/bottomnav.php";
        }

    ?>

    <!-- ------------------------------------------------- home --------------------------------------------------- -->

    <section class="home">

        <div class="row">

            <div class="content">
                
                <h3>مرحبا بك في مكتبة ميمونة</h3>
                <p>إكتشف عالما من القصص والمعرفة المذهلة في مكتبتنا. انغمس في نسيج الأدب الغني الذي ينتظرك. من الروايات الجذابة إلى القصص الواقعية، تم تصميم مجموعتنا لإلهام وإسعاد القراء من جميع الأذواق.</p>
                <a href="shop" class="btn">تسوق الآن</a>

            </div>

            <div class="swiper books-slider">

                <div class="swiper-wrapper">

                    <?php 
                    
                        $books = $database->prepare("SELECT * FROM Products WHERE ( CategoryID = 1 OR CategoryID = 2 ) AND Quantity > 0;");
                        $books->execute();

                        foreach ($books as $book) {
                            echo '
                            <a href="product?pid='.$book['ProductID'].'" class="swiper-slide">
                                <img src="'.$book['ImageURL'].'" alt="'.$book['Name'].'">
                            </a>
                            ';
                        }

                    ?>

                </div>
                <img src="images/stand.png" class="stand" alt="رف الكتب">
            </div>

        </div>

    </section>

    <!-- -------------------------------------------------- icons ----------------------------------------------- -->

    <section class="icons-container">

        <div class="icons">
            <i class="fa-solid fa-truck"></i>
            <div class="content">
                <h3>توصيل سريع</h3>
                <p>من يوم إلى 3 أيام كحد أقصى</p>
            </div>
        </div>

        <div class="icons">
            <i class="fa-solid fa-wallet"></i>
            <div class="content">
                <h3>الدفع عند الإستلام</h3>
                <p>دفع آمن 100%</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-redo-alt"></i>
            <div class="content">
                <h3>سهولة الإرجاع</h3>
                <p>بشكل فوري</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-headset"></i>
            <div class="content">
                <h3>24/7 دعم</h3>
                <p>إتصل بنا في أي وقت</p>
            </div>
        </div>

    </section>

    <!-- ------------------------------------------------- bestsellers -------------------------------------------- -->

    <section class="bestsellers">

        <h1 class="heading"><span>الأكثر مبيعا</span></h1>

        <div class="swiper product-slider">

            <div class="swiper-wrapper">

                <?php 
                    
                    $bestsellers = $database->prepare("SELECT Products.*, CASE WHEN Wishlist.ProductID IS NOT NULL THEN 1 ELSE 0 END AS InWishlist
                        FROM 
                            Products
                        LEFT JOIN 
                            Wishlist 
                        ON
                            Products.ProductID = Wishlist.ProductID AND Wishlist.UserID = :USER_ID
                        WHERE 
                            Bestseller = 1 AND (CategoryID = 1 OR CategoryID = 2) AND Quantity > 0
                        ORDER BY 
                            ProductID DESC;");
                    $bestsellers->bindParam("USER_ID" , $_SESSION['userid']);
                    $bestsellers->execute();
                    foreach ($bestsellers as $bestseller) {

                        echo '<div class="swiper-slide box">';

                        if($bestseller['InWishlist']){
                            echo '
                            <div class="wishlist">
                                <a class="fas fa-heart add-to-wishlist active" data-product-id="'.$bestseller['ProductID'].'"></a>
                            </div>';
                        }else{
                            echo '
                            <div class="wishlist">
                                <a class="fas fa-heart add-to-wishlist" data-product-id="'.$bestseller['ProductID'].'"></a>
                            </div>';
                        }

                        echo '
                        <div class="image">
                            <img class="product-image" data-product-id="'.$bestseller['ProductID'].'" src="'.$bestseller['ImageURL'].'" alt="'.$bestseller['Name'].'">
                        </div>
                        ';

                        if($bestseller['Discount'] == 0){
                            echo '
                                <div class="content">
                                    <h3>'.$bestseller['Name'].'</h3>
                                    <div class="price">'.$bestseller['Price'].'دج</div>
                                    <a class="btn add-to-cart" data-product-id="'.$bestseller['ProductID'].'" data-product-name="'.$bestseller['Name'].'" data-product-price="'.$bestseller['Price'].'">أضف إلى السلة</a>
                                </div>
                            ';
                        }else{
                            echo '
                                <div class="content">
                                    <h3>'.$bestseller['Name'].'</h3>
                                    <div class="price">'.$bestseller['Discount'].'دج <span>'.$bestseller['Price'].'دج</span></div>
                                    <a class="btn add-to-cart" data-product-id="'.$bestseller['ProductID'].'" data-product-name="'.$bestseller['Name'].'" data-product-price="'.$bestseller['Discount'].'">أضف إلى السلة</a>
                                </div>
                            ';
                        }
                        echo '</div>';
                        
                    }
                ?>

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>

    <!-- -------------------------------------------------- novels ------------------------------------------------ -->
    <section class="novels">

        <h1 class="heading"><span>الروايات</span></h1>

        <div class="swiper product-slider">

            <div class="swiper-wrapper">

            <?php 
                    
                $novels = $database->prepare("SELECT Products.*, CASE WHEN Wishlist.ProductID IS NOT NULL THEN 1 ELSE 0 END AS InWishlist
                    FROM 
                        Products
                    LEFT JOIN 
                        Wishlist 
                    ON
                        Products.ProductID = Wishlist.ProductID AND Wishlist.UserID = :USER_ID
                    WHERE 
                        CategoryID = 2 AND Quantity > 0 
                    ORDER BY 
                        ProductID DESC 
                    LIMIT 
                        10;");
                $novels->bindParam("USER_ID" , $_SESSION['userid']);
                $novels->execute();
                foreach ($novels as $novel) {

                    echo '<div class="swiper-slide box">';

                    if($novel['InWishlist']){
                        echo '
                        <div class="wishlist">
                            <a class="fas fa-heart add-to-wishlist active" data-product-id="'.$novel['ProductID'].'"></a>
                        </div>';
                    }else{
                        echo '
                        <div class="wishlist">
                            <a class="fas fa-heart add-to-wishlist" data-product-id="'.$novel['ProductID'].'"></a>
                        </div>';
                    }

                    echo '
                    <div class="image">
                        <img class="product-image" data-product-id="'.$novel['ProductID'].'" src="'.$novel['ImageURL'].'" alt="'.$novel['Name'].'">
                    </div>
                    ';

                    if($novel['Discount'] == 0){
                        echo '
                            <div class="content">
                                <h3>'.$novel['Name'].'</h3>
                                <div class="price">'.$novel['Price'].'دج</div>
                                <a class="btn add-to-cart" data-product-id="'.$novel['ProductID'].'" data-product-name="'.$novel['Name'].'" data-product-price="'.$novel['Price'].'">أضف إلى السلة</a>
                            </div>
                        ';
                    }else{
                        echo '
                            <div class="content">
                                <h3>'.$novel['Name'].'</h3>
                                <div class="price">'.$novel['Discount'].'دج <span>'.$novel['Price'].'دج</span></div>
                                <a class="btn add-to-cart" data-product-id="'.$novel['ProductID'].'" data-product-name="'.$novel['Name'].'" data-product-price="'.$novel['Discount'].'">أضف إلى السلة</a>
                            </div>
                        ';
                    }
                    echo '</div>';
                    
                }
            ?>

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>

    <!-- ----------------------------------------------- newly added ---------------------------------------------- -->
    
    <section class="newly-added">

        <h1 class="heading"><span>تم إضافته حديثا</span></h1>

        <div class="swiper product-slider">

            <div class="swiper-wrapper">

            <?php 
                    
                $news = $database->prepare("SELECT Products.*, CASE WHEN Wishlist.ProductID IS NOT NULL THEN 1 ELSE 0 END AS InWishlist
                    FROM 
                        Products
                    LEFT JOIN 
                        Wishlist 
                    ON
                        Products.ProductID = Wishlist.ProductID AND Wishlist.UserID = :USER_ID AND Quantity > 0
                    ORDER BY 
                        ProductID DESC
                    LIMIT 
                        5;");
                $news->bindParam("USER_ID" , $_SESSION['userid']);
                $news->execute();
                foreach ($news as $new) {

                    echo '<div class="swiper-slide box">';

                    if($new['InWishlist']){
                        echo '
                        <div class="wishlist">
                            <a class="fas fa-heart add-to-wishlist active" data-product-id="'.$new['ProductID'].'"></a>
                        </div>';
                    }else{
                        echo '
                        <div class="wishlist">
                            <a class="fas fa-heart add-to-wishlist" data-product-id="'.$new['ProductID'].'"></a>
                        </div>';
                    }

                    echo '
                    <div class="image">
                        <img class="product-image" data-product-id="'.$new['ProductID'].'" src="'.$new['ImageURL'].'" alt="'.$new['Name'].'">
                    </div>
                    ';

                    if($new['Discount'] == 0){
                        echo '
                            <div class="content">
                                <h3>'.$new['Name'].'</h3>
                                <div class="price">'.$new['Price'].'دج</div>
                                <a class="btn add-to-cart" data-product-id="'.$new['ProductID'].'"  data-product-name="'.$new['Name'].'" data-product-price="'.$new['Price'].'">أضف إلى السلة</a>
                            </div>
                        ';
                    }else{
                        echo '
                            <div class="content">
                                <h3>'.$new['Name'].'</h3>
                                <div class="price">'.$new['Discount'].'دج <span>'.$new['Price'].'دج</span></div>
                                <a class="btn add-to-cart" data-product-id="'.$new['ProductID'].'"  data-product-name="'.$new['Name'].'" data-product-price="'.$new['Discount'].'">أضف إلى السلة</a>
                            </div>
                        ';
                    }
                    echo '</div>';
                    
                }
            ?>

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>
    
    <!-- ----------------------------------------------- footer --------------------------------------------------- -->

    <?php

        if($database){
            require_once "templates/footer.php"; 
        }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script type="module" src="js/script.js"></script>
    <script type="module" src="js/home.js"></script>
    
</body>
</html>