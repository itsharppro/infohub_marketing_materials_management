import './bootstrap';

import 'jquery';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import 'jstree';
import 'jstree/dist/themes/default/style.min.css';
import 'jstree/dist/themes/default/style.min.css';

import 'dropzone'
import 'dropzone/dist/dropzone.css';
import Dropzone from 'dropzone';
window.Dropzone = Dropzone;

import 'jquery-validation';

// import './menu_tree';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();


document.addEventListener('DOMContentLoaded', () => {
    import('./menu_tree');
    import('./menu_delete');
    // import('./file_upload_validation');
    import('./menu_tree_files_upload');
    import('./file_upload');
    import('./upload-delete-file');
    import('./users');
    import('./menu_tree_permissions_group');
    import('./menu_tree_permissions_user');
    import('./accessRequest_validation');
});
