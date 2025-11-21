<!DOCTYPE html>
<html lang="en">
  <?php include_once("partials/head.php"); ?>
  <body>
     <script>
        var defaultThemeMode = "light"; 
        var themeMode = document.documentElement.hasAttribute("data-bs-theme-mode") 
            ? document.documentElement.getAttribute("data-bs-theme-mode") 
            : (localStorage.getItem("data-bs-theme") ?? defaultThemeMode);

        if (themeMode === "system") { 
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    </script>

    <?php echo $content; ?>
      
    <?php include_once("partials/script.php"); ?>
     
  </body>
</html>
