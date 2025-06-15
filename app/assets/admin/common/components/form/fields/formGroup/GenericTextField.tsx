import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import InputField from '@admin/common/components/form/input/InputField';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import FormGroup from '@admin/common/components/form/FormGroup';
import LabelNameIcon from '@/images/icons/label-name.svg';
import Description from '@admin/common/components/Description';

interface GenericTextFieldProps<T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
    fieldName: Path<T>;
    label: string;
    isRequired?: boolean;
    placeholder?: string | null;
    minLength?: number;
    maxLength?: number;
    id?: string;
    description?: string | null;
}


const GenericTextField = <T extends FieldValues>({
    register,
    fieldErrors,
    fieldName,
    label,
    placeholder = null,
    isRequired = false,
    minLength = 2,
    maxLength = 255,
    description = null,
    id,
}: GenericTextFieldProps<T>) => {
    const error = fieldErrors?.[fieldName];
    const descriptionElement = description ? <Description>{description}</Description> : null;

    return (
        <FormGroup
            label={<InputLabel isRequired={isRequired} label={label} htmlFor={id || fieldName} />}
            description={descriptionElement}
        >
            <InputField
                type="text"
                id={id || fieldName}
                hasError={!!error}
                placeholder={placeholder ?? ''}
                errorMessage={error?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register(fieldName, {
                    ...(isRequired && validationRules.required()),
                    ...(minLength && validationRules.minLength(minLength)),
                    ...(maxLength && validationRules.maxLength(maxLength))
                })}
            />
        </FormGroup>
    );
}

export default GenericTextField;
