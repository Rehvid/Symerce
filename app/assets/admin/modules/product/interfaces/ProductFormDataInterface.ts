import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface ProductFormDataInterface extends FormDataInterface {
  name: string,
  slug?: string
  description?: string
  isActive: boolean,
  mainCategory: number,
  categories?: number[],
  tags?: number[],
  vendor: number,
  deliveryTime: number,
  regularPrice: string,
  promotionIsActive?: boolean,
  promotionDateRange?: string[],
  promotionReduction?: string,
  promotionReductionType? :number,
  promotionSource: string
  stockAvailableQuantity: number,
  stockLowStockThreshold?: null|number,
  stockMaximumStockLevel?: null|number,
  stockEan13?: null|number,
  stockSku?: null|number,
  stockNotifyOnLowStock?: boolean,
  stockVisibleInStore?: boolean,
}
