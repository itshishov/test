<!Doctype html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Восстановление пароля</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="shortcut icon" type="image/x-icon" href="public/img/favicon.png">
   <link rel="stylesheet" href="/public/css/bootstrap.min.css">
   <link rel="stylesheet" href="/public/css/slicknav.css">
   <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <header>
         <div class="header-area ">
             <div class="header_top">
                 <div class="container">
                     <div class="row align-items-center">
                         <div class="col-xl-4 col-md-4 d-none d-md-block">
                             <div class="header_links ">  
                                 <ul>
                                     <li>Логотип</li>
                                 </ul>  
                             </div>
                         </div>
                         <div class="col-xl-4 col-md-4">
                             <div class="logo">
                                 <a href="index.html">
                                   <span style="font-size: 20px">Краснодарская доска объявлений</span>  <!--<img src="img/logo.png" alt="">-->
                                 </a>
                             </div>
                         </div>
                          <div class="col-xl-4 col-md-4 d-none d-md-block">
                             <div class="login_resiter">
                              <a href="/ads/add"><button type="button" class="btn btn-warning">Добавить объявление</button></a> 
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div id="sticky-header" class="main-header-area white-bg">
                 <div class="container">
                     <div class="row align-items-center">
                         <div class="col-xl-7 col-lg-7">
                             <div class="main-menu  d-none d-lg-block">
                                <nav>
                                     <ul id="navigation">
                                         <li><a href="/">Главная</a></li>
                                     </ul>
                                 </nav>
                             </div>
                         </div>
                         <div class="col-12">
                             <div class="mobile_menu d-block d-lg-none"></div>
                         </div>
                     </div> 
                 </div>
             </div>
         </div>
     </header>
    <section class="contact-section">
            <div class="container">
        <h1 class="contact-title">Восстановление пароля</h1>   
                <div class="row">
                    <div class="col-lg-8">
                        <form class="form-contact contact_form" action="/user/forgot" method="post" >
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                          <input class="form-control valid" name="email"   type="email"  placeholder="Введите email" id="email" required>
                                    </div>
                                </div>
                            </div>
                         <div class="form-group mt-3">
                                <button type="submit" class="button button-contactForm boxed-btn">Восстановить</button>
                            </div>
                        </form>
                    </div>
                        <div class="col-lg-4">
               <div class="blog_right_sidebar">
                 <aside class="single_sidebar_widget search_widget">
               <a href="/user/index"><p style="color: blue">Регистрация</p></a>
                  </aside>
               </div>
            </div>
                </div>
            </div>
        </section>
        <div style="padding-top:130px"> <?php require_once 'public/blocks/footer.php' ?></div>