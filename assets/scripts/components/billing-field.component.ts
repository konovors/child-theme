const $ = jQuery;

export class BillingField {
  private $typeControl: JQuery<HTMLInputElement>;

  constructor() {
    this.$typeControl = $('.type-control input');
  }

  run(): void {
    this.bindEvents();
    this.toggleCompanyFields($('.type-control input:checked').val() as string);
  }

  private bindEvents(): void {
    this.$typeControl.on('change', (event) => {
      const type = $(event.currentTarget).val() as string;
      this.setBillingType(type);
      this.toggleCompanyFields(type);
    });
  }

  private toggleCompanyFields(type: string): void {
    if (type == 'company') {
      $('.hide-if-person').addClass('shown');
      $('.hide-if-person input').prop('disabled', false);
      return;
    }

    $('.hide-if-person').removeClass('shown');
    $('.hide-if-person input').prop('disabled', true).removeAttr('required');
  }

  private setBillingType(type: string): void {
    const formData = new FormData();
    formData.append('action', 'set_billing_type');
    formData.append('type', type);

    fetch(window.knv.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      body: formData,
    }).then(() => {
      document.body.dispatchEvent(new Event('update_checkout'));
    });
  }
}
