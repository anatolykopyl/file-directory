<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">

	  <link rel="shortcut icon" type="image/png" href="/favicon-32x32.png"/>
    <title>radner.ru</title>
  </head>
  <body>
    <div class="container">
      <div class="row my-5">
        <h1 class="col">Загрузки: &#128229 </h1>
        <div class="col text-right">
          <?php
            session_start();
            //session_unset();

            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
              echo '<p class="mt-3">Авторизован</p>';
            } else {
              echo '<button class="btn btn-light mt-2" data-toggle="dropdown">Авторизоваться </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left w-50">
                  <form class="px-4 py-3" method="post" action="login.php">
                    <div class="form-group">
                      <label for="password">Пароль</label>
                      <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <input type="submit" class="btn btn-primary col-auto" value="Войти">
                    <a class="col-auto" data-toggle="collapse" href="#collapseGetPass" role="button">Узнать пароль</a>
                  </form>
                    <div class="collapse" id="collapseGetPass">
                      <form class="px-4 py-3" method="post" action="sendpass.php">
                        <div class="form-group">
                          <label for="inputEmail">На какой адрес выслать пароль</label>
                          <input type="email" class="form-control" name="inputEmail" placeholder="Введите почту">
                        </div>
                        <input type="submit" class="btn btn-primary col-auto" value="Отправить">
                      </form>
                    </div>
                </div>';
            }
          ?>
        </div>
      </div>

      <div class="list-group shadow rounded">
        <?php
          $dir = "files/";
          
          if ($dh = opendir($dir)) {
            while (($filename = readdir($dh)) !== false) {
              if (!is_dir($dir . $filename) && substr($filename, 0, 1) !== "." && $filename !== "@eaDir") {

                $filetag = str_replace(' ', '', $filename);
                $filetag = preg_replace('/[^A-Za-z0-9\-]/', '', $filetag);
                
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                switch ($ext) {
                  case "exe":
                    $clr = " list-group-item-danger";
                  break;
                  case "mp4":
                    $clr = " list-group-item-info";
                  break;
                  case "jpg":
                  case "jpeg":
                  case "png":
                  case "gif":
                    $clr = " list-group-item-warning";
                  break;
                  case "zip":
                  case "rar":
                    $clr = " list-group-item-secondary";
                  break;
                  case "private":
                    $clr = " list-group-item-dark";
                  break;
                  default:
                    $clr = "";
                }
                
                $filesize = filesize("files/" . $filename);
                $msr = " bytes";
                if ($filesize > 1024**3) {
                  $filesize /= 1024**3;
                  $msr = " GB";
                } elseif ($filesize > 1024**2) {
                  $filesize /= 1024**2;
                  $msr = " MB";
                } elseif ($filesize > 1024) {
                  $filesize /= 1024;
                  $msr = " KB";
                }

                if ($msr == " bytes") {
                  $filesize = $filesize . $msr;
                } else {
                  $filesize = number_format($filesize, 2, ",", " ") . $msr;
                }
                
                echo "<span class='list-group-item list-group-item-action border border-secondary p-2" . $clr . "'><span class='row d-flex justify-content-between align-items-center'><a class='col-11 row text-decoration-none' ";

                if ($ext == "private") {
                  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
                    echo "download='" . pathinfo($filename, PATHINFO_FILENAME) . "' href='files/" . $filename . "'><span class='col-5'>" . pathinfo($filename, PATHINFO_FILENAME);
                  } else {
                    echo "><span class='col-5 text-muted'>" . pathinfo($filename, PATHINFO_FILENAME);
                  }
                } else {
                  echo "download href='files/" . $filename . "'><span class='col-5'>" . $filename;
                }

                echo "</span><span class='col-4 text-secondary'>" . $filesize . "</span>";
                if ($ext == "private" && !(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)) {
                  echo "<span class='col text-secondary text-right'>Требуется авторизация</span>";
                }
                echo "</a>";

                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
                  if ($ext == "mp4") {
                    echo "<a class='col-1 text-decoration-none text-center my-n3 p-2 border-left border-secondary d-none d-lg-block' href='files/" . $filename . "'>📼</a>";
                  } elseif ($clr == " list-group-item-warning") {
                    echo "<a class='col-1 text-decoration-none text-center my-n3 p-2 border-left border-secondary my-n3 d-none d-lg-block' data-toggle='collapse' data-target='#collapse-" . $filetag . "'>🖼️</a>";
                  } else {
                    echo "<span class='col-1'></span>\n";
                  }
                  echo "<div class='collapse container-fluid border-top border-secondary text-center m-2' id='collapse-" . $filetag . "'><img class='border mt-3' src='files/" . $filename . "'></div>\n";
                  echo "</span></span>\n";
                } else {
                  if ($ext == "mp4") {
                    echo "<a class='col-1 text-decoration-none text-center my-n3 p-2 border-left border-secondary d-none d-lg-block' href='files/" . $filename . "'>📼</a>";
                  } elseif ($clr == " list-group-item-warning") {
                    echo "<a class='col-1 text-decoration-none text-center my-n3 p-2 border-left border-secondary my-n3 d-none d-lg-block' data-toggle='collapse' data-target='#collapse-" . $filetag . "'>🖼️</a>";
                  } else {
                    echo "<span class='col-1'></span>\n";
                  }
                  if ($clr == " list-group-item-warning") {
                    echo "<div class='collapse container-fluid border-top border-secondary text-center m-2' id='collapse-" . $filetag . "'><img class='border mt-3' src='files/" . $filename . "'></div>\n";
                  }
                  echo "</span></span>\n";
                }
              }
            }
            closedir($dh);
          }
        ?>
      </div>

      <br><br>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="main.js"></script>
  </body>
</html>
