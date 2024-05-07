{extends file="template/admin-dashboard.tpl"}

{block name="title"}
    GameHub | Admininformation
{/block}

{block name="admin-information"}
    <style>
        .card {
            display: grid;
            grid-template-columns: auto auto auto;
            padding: 10px;
        }

        .grid-container{
            display: flex;
            justify-content: right;
        }

        .grid-item{
            background-color: orange;
            border: 10px solid rgba(0, 0, 0, 0.8);
            padding: 20px;
            font-size: 20px;
            text-align: center;
            border-radius: 20px 20px 20px 20px;
            color: black;
        }
    </style>


    <div class="row" style="padding-left: 1%">
        <div class="grid-container" style="width: 25%; padding-top: 3%">
            <div class="card-body">
                <h2>Mijn beheergegevens</h2>
                <p>Dit zijn uw gegevens</p>
                <h4>Klantnummer:</h4>
                <div class="grid-item">{$smarty.session.admin.id}</div>
                <h4>Username:</h4>
                <div class="grid-item">{$smarty.session.admin.username}</div>
                <h4>Emailadres:</h4>
                <div class="grid-item">{$smarty.session.admin.emailadress}</div>
                <h4>Telefoon nummer:</h4>
                <div class="grid-item">{$smarty.session.admin.phonenumber}</div>

                {*            <div type="submit"><a href="index.php?action=userUpdateLocate"> > Gegevens Aanpassen</a></div>*}
            </div>
        </div>
    </div>




{/block}