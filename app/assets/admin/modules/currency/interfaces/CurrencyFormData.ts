import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';

export interface CurrencyFormData extends FormDataInterface {
    id?: number | null;
    name: string;
    symbol: string;
    code: string;
    roundingPrecision: number;
}
