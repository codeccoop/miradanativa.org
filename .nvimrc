lua << EOF
local dap = require('dap')
dap.configurations.php = {
  {
    type = "php",
    request = "launch",
    name = "Listen for Xdebug",
    port = 9003,
    pathMappings = {
        ["/var/www/html/wp-content/themes/miradanativa"] = "${workspaceFolder}"
    }
  }
}
EOF
