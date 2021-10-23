<?php
  // unlink('files/' . $_POST["file"]);
  rename("files/" . $_POST["file"], ".removed/" . $_POST["file"]);
?>