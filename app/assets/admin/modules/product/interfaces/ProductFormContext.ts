import { SelectOption } from '@admin/common/types/selectOption';
import { AttributeType } from '@admin/modules/attribute/enums/AttributeType';

interface SelectAttribute {
    name: string;
    options: any;
    label: string;
    type: AttributeType;
}

export interface ProductFormContext {
    availableBrands: SelectOption[];
    availableCategories: SelectOption[];
    availableTags: SelectOption[];
    availablePromotionTypes: SelectOption[];
    availableWarehouses: SelectOption[];
    availableAttributes: SelectAttribute[];
}
