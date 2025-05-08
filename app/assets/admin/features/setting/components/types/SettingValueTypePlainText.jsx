import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';

const SettingValueTypePlainText = ({ register, fieldErrors }) => (
    <Input
        {...register('value', {
            ...validationRules.required(),
            ...validationRules.minLength(3),
        })}
        type="text"
        id="value"
        label="Wartość"
        hasError={!!fieldErrors?.value}
        errorMessage={fieldErrors?.value?.message}
        isRequired
    />
);

export default SettingValueTypePlainText;
