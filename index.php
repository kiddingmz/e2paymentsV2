<?php
    require_once('libs/config.php');
    require 'libs/e2PaymentsGuzzle.php';

    $url = 'https://e2payments.explicador.co.mz';

    $payC2B = new PaymentsC($url);

    $corpo = $payC2B->payC2B();
    $dados = json_decode($corpo, true);
    $alertaValor = '';
    $alertaCell = '';
    if(!empty($_POST['celular'])){
        if(!empty($_POST['valor'])){
            if(!empty($_POST['ref'])){
                
                $resposta2 = $cliente->request('POST', '/v1/c2b/mpesa-payment/856853', [
                    "headers" => [
                        'Authorization' => sprintf("Bearer %s", $dados['access_token']),
                        'Accept' => "application/json",
                        'Content-Type' =>"application/json"
                    ],
                    'json' => [
                       'client_id' => constant('CLID'),
                       'amount' => addslashes($_POST['valor']),
                       'phone' => addslashes($_POST['celular']),
                       'reference' => addslashes($_POST['ref']),

                    ]
                ]);

                //echo $resposta2->getStatusCode().'<br>';
                $corpo = $resposta2->getBody();
                $dados = json_decode($corpo, true);

                $show = 'show';
                $hiden = '';

                $suc = 'success';
                $dan = 'danger';
                //var_dump($dados);
                //echo $resposta2->getStatusCode();
                
                if($resposta2->getStatusCode() == 200 || $resposta2->getStatusCode() == 201){
                    $msg = "Pagamento efectuado com sucesso";
                    $info1 = $show;
                    $info2 = $suc;
                }else{
                    
                    $msg = "Pagamento não efectuado";
                    $info1 = $show;
                    $info2 = $dan;
                }

            }else{

            }
        }else{
            $alertaValor = 'is-invalid';
        }
                
    }else{
        $alertaCell = 'is-invalid';
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.3/gh-fork-ribbon.min.css" />
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/notify.js">
        
    </script>

    </script>
    <title>Pagamentos Mpesa</title>
  </head>
  <body>
    <header class="pb-1 pt-1 bg-dark text-white">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center justify-content-start te"><h5>e2Payments Live Tests</h5></div>
                <div class="d-flex align-items-center justify-content-end"><small>e2Payments v1.0.0</small></div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-9 pt-5">
                <div class="text-center p-5">
                    <img src="https://user-images.githubusercontent.com/18400142/132318330-b8536515-d0d3-44ba-817e-ee2d269722f6.png" alt="" style="width: 100px; height: 100px;">
                </div>
                <form method="POST" action="#">
                    <div class="form-group form-floating">

                        <input type="tel" class="form-control <?php echo $alertaCell;?>" id="celular" name="celular" placeholder="84/85XXXXXXX" required>
                        <label for="celular">Numero com Mpesa 84/85</label>
                    </div>
                    <div class="form-group 
                    form-floating">
                        <input type="number" class="form-control <?php echo $alertaValor;?>" id="valor" name="valor" required placeholder="Valor">
                        <label for="valor">Valor a pagar</label>
                    </div>
                    
                    <div class="form-floating">
                      <select class="form-select" name="ref" id="floatingSelectGrid" aria-label="Floating label select example">
                        <option value="Live">Live</option>
                        <option value="TestarPagamento">Testar Pagamento</option>
                        <option value="Curso">Curso</option>
                      </select>
                      <label for="floatingSelectGrid">Indique a refêrencia</label>
                      <script type="text/javascript">
                        $( "#floatingSelectGrid" ).val();
                        $( "#floatingSelectGrid option:selected" ).text();
                    </script>

                    </div><br>
                  
                    <button type="submit" class="btn btn-dark d-flex justify-content-end">Pagamento</button><br>

                    <div id="info" class=" alert alert-<?php echo $info2;?> alert-dismissible fade <?php echo $info1;?> " role="alert"><?php  echo $msg; $info1 ='f';?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>          
                        
                </form>   
            </div>
        </div>

        
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>