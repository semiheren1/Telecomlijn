{extends file="template/layout.tpl"}

{block name="title"}
    Parkeren | Home
{/block}


{block name="homePage"}
    <style>
        .d-md-flex flex-md-equal w-100 my-md-3 ps-md-3{
            display: inline-block;
        }

        img{
            height: 100%;
            width: 75%;
            object-fit: contain;
        }

    </style>
    <main>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary" >
        <div class="col-md-6 p-lg-5 mx-auto my-5" href="#">
            <h1 class="display-3 fw-bold"><img src="../img/GameHub.png"></h1>
            {*        <h3 class="fw-normal text-muted mb-3">Games</h3>*}
            <div class="d-flex gap-3 justify-content-center lead fw-normal">
                <a class="icon-link" href="index.php?action=productPage" style="color: orange; text-decoration: none; border-bottom: 1px solid orange">All products ></a>
            </div>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

    <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3" >
        <div class="text-bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
            <div class="my-3 py-3" >
                <h2 class="display-5">Playstation</h2>
                <a class="lead" href="index.php?action=playstationPage" style="color: orange; text-decoration: none; border-bottom: 1px solid orange">Buy ></a>
            </div>
            <div class="bg-body-tertiary shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"><img src="img/playstation.png"></div>
        </div>

        <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden" style="width: 35%" >
            <div class="my-3 p-3" >
                <h2 class="display-5">Xbox</h2>
                <a class="lead" href="index.php?action=xboxPage" style="color: orange; text-decoration: none; border-bottom: 1px solid orange">Buy ></a>
                {*          <a class="icon-link" href="index.php?action=xboxPage" style= "color: orange; text-decoration: none; border-bottom: 1px solid orange">Buy ></a>*}
            </div>
            <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"><img src="img/xbox.png"></div>
        </div>

        <div class="text-bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden" >
            <div class="my-3 py-3">
                <h2 class="display-5">Nintendo</h2>
                <a class="lead" href="index.php?action=nintendoPage" style="color: orange; text-decoration: none; border-bottom: 1px solid orange">Buy ></a>
            </div>
            <div class="bg-body-tertiary shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"><img src="img/nintendo.png"></div>
        </div>

    </div>


{/block}