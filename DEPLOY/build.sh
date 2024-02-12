#!/usr/bin/env bash

#######################
### laravel install ###
#######################

deploy_src="DEPLOY/www"
version_laravel="^10.3"
version_vue="3.4.15"
version_vue_loader="17.4.2"
version_webpack="5.90.1"
version_laravel_mix="6.0.49"
version_vitejs_vue="5.0.3"

cd "../$(dirname "$0")"
echo "COMMAND 'composer create-project laravel/laravel laravel':"
               composer create-project laravel/laravel=$version_laravel laravel
php laravel/artisan --version

echo "COMMAND 'mv laravel/* .':"  && mv    laravel/* .
echo "COMMAND 'mv laravel/.* .':" && mv    laravel/.* .
echo "COMMAND 'rmdir laravel':"   && rmdir laravel

echo "COMMAND 'composer require barryvdh/laravel-debugbar':"       && composer require barryvdh/laravel-debugbar --dev
echo "COMMAND 'composer require ariaieboy/laravel-safe-browsing':" && composer require ariaieboy/laravel-safe-browsing

###################
### npm install ###
###################

echo "COMMAND 'npm install':"             && npm install
echo "VERSION INSTALLED:"                 && npm -v

echo "COMMAND 'npm install vue':"         && npm install vue@$version_vue --save-dev
echo "VERSION AVAILABLE:"                 && npm info vue version
echo "VERSION INSTALLED:"                 && npm list --depth=0 | grep "vue@" | sed "s/├── //g" | sed "s/└── //g" | sed "s/vue@//g"

echo "COMMAND 'npm install vue-loader':"  && npm install vue-loader@$version_vue_loader --save-dev
echo "VERSION AVAILABLE:"                 && npm info vue-loader version
echo "VERSION INSTALLED:"                 && npm list --depth=0 | grep "vue-loader@" | sed "s/├── //g" | sed "s/└── //g" | sed "s/vue-loader@//g"

echo "COMMAND 'npm install webpack':"     && npm install webpack@$version_webpack --save-dev
echo "VERSION AVAILABLE:"                 && npm info webpack version
echo "VERSION INSTALLED:"                 && npm list --depth=0 | grep "webpack@" | sed "s/├── //g" | sed "s/└── //g" | sed "s/webpack@//g"

echo "COMMAND 'npm install laravel-mix':" && npm install laravel-mix@$version_laravel_mix --save-dev
echo "VERSION AVAILABLE:"                 && npm info laravel-mix version
echo "VERSION INSTALLED:"                 && npm list --depth=0 | grep "laravel-mix@" | sed "s/├── //g" | sed "s/└── //g" | sed "s/laravel-mix@//g"

echo "COMMAND 'npm install plugin-vue':"  && npm install @vitejs/plugin-vue@$version_vitejs_vue --save-dev
echo "VERSION AVAILABLE:"                 && npm info @vitejs/plugin-vue version
echo "VERSION INSTALLED:"                 && npm list --depth=0 | grep "@vitejs/plugin-vue@" | sed "s/├── //g" | sed "s/└── //g" | sed "s/@vitejs\/plugin-vue@//g"

###################
### controllers ###
###################

file_ctrl_short_link_from="$deploy_src/app/Http/Controllers/ShortLinks.php"
file_ctrl_short_link_to="app/Http/Controllers/ShortLinks.php"
echo "CREATE FILE '$file_ctrl_short_link_to':"
cp $file_ctrl_short_link_from $file_ctrl_short_link_to

##############
### models ###
##############

file_model_short_link_from="$deploy_src/app/Models/ShortLinks.php"
file_model_short_link_to="app/Models/ShortLinks.php"
echo "CREATE FILE '$file_model_short_link_to':"
cp $file_model_short_link_from $file_model_short_link_to

##################
### migrations ###
##################

file_migr_short_link_from="$deploy_src/database/migrations/2024_02_10_091225_create_short_links_table.php"
file_migr_short_link_to="database/migrations/2024_02_10_091225_create_short_links_table.php"
echo "CREATE FILE '$file_migr_short_link_to':"
cp $file_migr_short_link_from $file_migr_short_link_to

#################
### resources ###
#################

mkdir ./resources/components

file_comp_messages_from="$deploy_src/resources/components/messages.vue"
file_comp_messages_to="resources/components/messages.vue"
echo "CREATE FILE '$file_comp_messages_to':"
cp $file_comp_messages_from $file_comp_messages_to

file_comp_short_links_from="$deploy_src/resources/components/short_links.vue"
file_comp_short_links_to="resources/components/short_links.vue"
echo "CREATE FILE '$file_comp_short_links_to':"
cp $file_comp_short_links_from $file_comp_short_links_to

###################################################

file_css_app_from="$deploy_src/resources/css/app.css"
file_css_app_to="resources/css/app.css"
echo "REPLACE FILE '$file_css_app_to':"
cp $file_css_app_from $file_css_app_to

###################################################

file_js_app="resources/js/app.js"
echo "DELETE FILE '$file_js_app':"
unlink $file_js_app

file_js_short_links_app_from="$deploy_src/resources/js/short_links-app.js"
file_js_short_links_app_to="resources/js/short_links-app.js"
echo "CREATE FILE '$file_js_short_links_app_to':"
cp $file_js_short_links_app_from $file_js_short_links_app_to

file_js_url_validator_from="$deploy_src/resources/js/url_validator.js"
file_js_url_validator_to="resources/js/url_validator.js"
echo "CREATE FILE '$file_js_url_validator_to':"
cp $file_js_url_validator_from $file_js_url_validator_to

###################################################

file_view_welcome="resources/views/welcome.blade.php"
echo "DELETE FILE '$file_view_welcome':"
rm $file_view_welcome

file_view_home_from="$deploy_src/resources/views/home.blade.php"
file_view_home_to="resources/views/home.blade.php"
echo "CREATE FILE '$file_view_home_to':"
cp $file_view_home_from $file_view_home_to

file_view_short_links_from="$deploy_src/resources/views/short_links-vue.blade.php"
file_view_short_links_to="resources/views/short_links-vue.blade.php"
echo "CREATE FILE '$file_view_short_links_to':"
cp $file_view_short_links_from $file_view_short_links_to

file_view_short_links_test_manual_from="$deploy_src/resources/views/short_links-test_manual.blade.php"
file_view_short_links_test_manual_to="resources/views/short_links-test_manual.blade.php"
echo "CREATE FILE '$file_view_short_links_test_manual_to':"
cp $file_view_short_links_test_manual_from $file_view_short_links_test_manual_to

##############
### routes ###
##############

file_routes_web_from="$deploy_src/routes/web.php"
file_routes_web_to="routes/web.php"
echo "REPLACE FILE '$file_routes_web_to':"
cp $file_routes_web_from $file_routes_web_to

####################
### root configs ###
####################

file_config_vite_from="$deploy_src/vite.config.js"
file_config_vite_to="vite.config.js"
echo "REPLACE FILE '$file_config_vite_to':"
cp $file_config_vite_from $file_config_vite_to

file_config_webpack_from="$deploy_src/webpack.mix.cjs"
file_config_webpack_to="webpack.mix.cjs"
echo "CREATE FILE '$file_config_webpack_to':"
cp $file_config_webpack_from $file_config_webpack_to

# echo "DB_CONNECTION=mysql"     >> .env
# echo "DB_HOST=127.0.0.1"       >> .env
# echo "DB_PORT=3306"            >> .env
# echo "DB_DATABASE=laravel-vue" >> .env
# echo "DB_USERNAME=root"        >> .env
# echo "DB_PASSWORD=123"         >> .env

touch database/database.sqlite;

echo ""                                          >> .env
echo "DB_CONNECTION=sqlite"                      >> .env
echo "DB_DATABASE=$PWD/database/database.sqlite" >> .env
echo ""                                          >> .env
echo "SAFEBROWSING_GOOGLE_API_KEY=AIzaSyDB-ihLoVColXiFAdYExIGoJjFOMuKcCD8" >> .env

#####################
### final actions ###
#####################

echo "COMMAND 'php artisan migrate':" && php artisan migrate:refresh
echo "COMMAND 'npm run build':"       && npm run build
echo "COMMAND 'npx mix':"             && npx mix
