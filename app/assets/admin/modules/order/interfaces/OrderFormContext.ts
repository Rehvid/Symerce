import { SelectOption } from '@admin/common/types/selectOption';

export interface OrderFormContext {
    availableCarriers: SelectOption[];
    availableCheckoutSteps: SelectOption[];
    availableCountries: SelectOption[];
    availablePaymentMethods: SelectOption[];
    availableProducts: SelectOption[];
    availableStatuses: SelectOption[];
    availableCustomers: SelectOption[];
}
