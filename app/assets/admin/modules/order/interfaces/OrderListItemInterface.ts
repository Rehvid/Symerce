import { Money } from '@admin/shared/types/money';

export interface OrderListItemInterface {
  id: number,
  status?: string,
  checkoutStep?: string,
  totalPrice?: Money,
  createdAt?: string,
  updatedAt:? string
}
