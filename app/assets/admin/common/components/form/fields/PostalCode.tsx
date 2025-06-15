import InputField from '@admin/common/components/form/input/InputField';
import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import LabelNameIcon from '@/images/icons/label-name.svg';

export interface PostalCodeField {
    postalCode?: string | null;
}

interface PostalCodeProps<T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
    fieldName?: keyof T;
}

const PostalCode = <T extends Record<string, any>>({
register,
fieldErrors,
fieldName = 'postalCode',
}: PostalCodeProps<T>) => (
    <InputField
        type="text"
        id={String(fieldName)}
        hasError={!!fieldErrors?.[fieldName]}
        errorMessage={fieldErrors?.[fieldName]?.message as string | undefined}
        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
        {...register(fieldName as Path<T>, {
            ...validationRules.required(),
            ...validationRules.postalCode(),
            ...validationRules.minLength(4),
        })}
    />
);

export default PostalCode;
