import { Money } from '@admin/shared/types/money';

export interface ProductListItemInterface {
  id: number,
  image?: string,
  isActive: boolean,
  name: string,
  quantity: number,
  showUrl: string,
  regularPrice: Money
}
