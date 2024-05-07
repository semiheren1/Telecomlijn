<?php
/* Smarty version 4.3.2, created on 2024-05-07 14:02:38
  from 'C:\xampp\htdocs\Telecomlijn\template\homePage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_663a185e6ec441_26999103',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9fc69cc4d4efd1cdfc781f0dde21c730e9bbccc6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Telecomlijn\\template\\homePage.tpl',
      1 => 1715069553,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_663a185e6ec441_26999103 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1903244355663a185e6eb035_61083172', "title");
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2136469639663a185e6eba10_12075219', "homePage");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "template/layout.tpl");
}
/* {block "title"} */
class Block_1903244355663a185e6eb035_61083172 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_1903244355663a185e6eb035_61083172',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    Parkeren | Home
<?php
}
}
/* {/block "title"} */
/* {block "homePage"} */
class Block_2136469639663a185e6eba10_12075219 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'homePage' => 
  array (
    0 => 'Block_2136469639663a185e6eba10_12075219',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

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


<?php
}
}
/* {/block "homePage"} */
}
