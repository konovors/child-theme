import { WpRouter } from '@wptoolset/router';

const routes = new WpRouter({});

jQuery(() => {
  routes.loadEvents();
});
