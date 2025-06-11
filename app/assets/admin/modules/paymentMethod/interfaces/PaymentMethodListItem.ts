import { Money } from '@admin/common/types/money';

export interface PaymentMethodListItem {
  id: number;
  name: string;
  isActive: boolean;
  code: string;
  imagePath?: string;
  fee: Money;
}
