import Vue from 'vue';
import { extend, ValidationProvider, ValidationObserver, localize } from 'vee-validate'
import * as rules from 'vee-validate/dist/rules';

for (let rule in rules) {
  extend(rule, rules[rule]);
}

Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)

function loadLocale(code) {
  return import(`vee-validate/dist/locale/${code}.json`).then(locale => {
    localize(code, locale);
  });
}

loadLocale(process.env.VUE_APP_I18N_LOCALE || 'vi')
