import Switch from '@shop/common/Switch';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';

interface FormSwitchFieldProps<T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors?: FieldErrors<T>;
    name: Path<T>;
    label: string;
}

const FormSwitchField = <T extends FieldValues>({
register,
name,
label,
}: FormSwitchFieldProps<T>) => (
    <FormGroup label={<InputLabel label={label}  />}>
        <Switch {...register(name)} />
    </FormGroup>
);

export default FormSwitchField;
