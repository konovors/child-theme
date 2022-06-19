export class ProductCat {
  private static columns = 3;

  private static classes = {
    '4': ['col-md-3', 'col-sm-4', 'col-6'],
    '3': ['col-md-4', 'col-sm-4', 'col-12'],
    '2': ['col-md-6', 'col-sm-6', 'col-6'],
    '1': ['col-md-12', 'col-sm-12', 'col-12'],
  };

  private catItems: NodeListOf<HTMLDivElement>;

  init(): void {
    this.catItems = document.querySelectorAll('.elements-grid .categories-with-shadow');
  }
  finalize(): void {
    this.reorganizeItems();
  }

  private reorganizeItems(): void {
    for (let i = 0; i < this.catItems.length; i += ProductCat.columns) {
      this.reorganizeBatch([...this.catItems].slice(i, i + ProductCat.columns));
    }
  }

  private reorganizeBatch(cats: HTMLDivElement[]): void {
    const toRemove = ProductCat.classes[4];
    const toAdd = ProductCat.classes[cats.length];

    cats.forEach((cat) => {
      cat.classList.remove(...toRemove);
      cat.classList.add(...toAdd);
    });
  }
}
