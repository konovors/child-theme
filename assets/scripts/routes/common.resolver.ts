import 'jquery-match-height';

const $ = jQuery;

export class Common {
  init(): void {
    //
  }

  finalize(): void {
    $('.knv-product .wd-entities-title').matchHeight();
  }
}
