import { WpRouter } from '@wptoolset/router';
import Checkout from './routes/checkout.resolver';
import { Common } from './routes/common.resolver';
import { EditAddress } from './routes/edit-address.resolver';
import { ProductCat } from './routes/product-cat.resolver';

const routes = new WpRouter({
  common: () => new Common(),
  checkout: () => new Checkout(),
  taxProductCat: () => new ProductCat(),
  woocommerceEditAddress: () => new EditAddress(),
});

jQuery(() => {
  routes.loadEvents();
});
