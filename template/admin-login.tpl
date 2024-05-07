{extends file="template/layout.tpl"}
{block name="footer"}{/block}

{block name="admin-login"}
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <fieldset style="border: 1px solid white; padding: 25px; border-radius: 5px">
            <legend>Login as admin</legend>
            <form method="post" action="index.php?action=login-adm">
                <div class="mb-3">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" name="email" placeholder="Email address">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                            <input class="showPassword" type="checkbox" onclick="myFunction()"> Show Password
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-sm btn-outline-success" name="submit" value="Sign in">
                    </div>
                </div>
            </form>
        </fieldset>
    </div>

    <script>
        // Toggle password visibility
        function myFunction() {
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
{/block}
