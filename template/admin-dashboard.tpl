{extends file="template/layout.tpl"}
{block name="title"}
    parkeren | Admin Dashboard
{/block}

{block name="navmenu"}{/block}

{block name="adm-dash"}
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.84.0">

        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

        <style>
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="template/css/dashboard.css" rel="stylesheet">
    </head>
    <body>



    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php?action=admin-dashboard">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file"></span>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=admin-products">
                                <span data-feather="shopping-cart"></span>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=admin-users">
                                <span data-feather="users"></span>
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=admin-admins">
                                <span data-feather="bar-chart-2"></span>
                                Admins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=logout">
                                <span data-feather="bar-chart-2"></span>
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    {block name="admin-information"}
    <h3>Beheerder:
        <button type="button" class="btn btn-warning" style="background-color: orange"><a style="text-decoration: none; color: inherit" href="index.php?action=admin-information">{$smarty.session.admin.username}</a></button></h3>
    {/block}
    </div>
    {block name="admins"}{/block}
    {block name="users"}{/block}
    {block name="admin-products"}{/block}
    {block name="addprod"}{/block}
</main>



        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
{/block}
