<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Dictionary</title>
</head>
<body>
  <form method="post" action="/uploads" enctype="multipart/form-data">
    <input name="dictionary" type="file" />
    <button type="submit">Upload</button>
  </form>
</body>
</html>