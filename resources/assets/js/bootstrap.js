

try {
	//apago esse aquivo também pois todos q não estiver utilizando faço o memso pois te-lós requer espaço
    //window.$ = window.jQuery = require('jquery');
    //posso fazer mesmo com o boostrap se não for usá-lo
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
//aqui seta os cabeçalhos para envios ajax
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
//aqui ele envia automáticamente o csrf token quando for fazer uma requisição post isso garante q não dê erro de csrf
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

//agora vamos para os aquivos sass em _variables.scss
