<?php 
include_once "header1.php";
?>
<section class="p-5">
    <div class="container text-center">
        <h1 class="signUpTitle">Добавяне на продукт</h1>
        <form id="reg-form" action="includes/add.php" method="POST" enctype="multipart/form-data" class="form w-75 w-lg-50 m-auto pt-4">          
        <input class="form-control my-4 regInput" type="id" name="ID" placeholder="ID на продукта">
        <input class="form-control my-4 regInput" type="name" name="productName" placeholder="Име на продукта">
        <input class="form-control my-4 regInput" type="price" name="price" placeholder="Цена на продукта">
        <input class="form-control my-4 regInput" type="size" name="size" placeholder="Размер на продукта">
        <input class="form-control my-4 regInput" type="description" name="description" placeholder="Описание на продукта">
        <div class="form-control my-4 regInput">
                        <div class="title lead">Избери снимка</div>                        
                        <div class="ropzone mx-autdo my-5">
                            <div>
                                <span class="filename"></span>
                                <input type="file" name="image[]" class="input" multiple>                                
                            </div>                            
                        </div>                        
                    </div>
                
                <button class="btn submitBtn btn-lg px-sm-5" style=" font-size: 25px;" type="submit" name="submit">Добавяне</button>
        </form>
    </div>

</section>
<?php 
include_once "footer.php";
?>