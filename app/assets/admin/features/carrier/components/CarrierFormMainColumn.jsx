import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';

const CarrierFormMainColumn = ({ register, fieldErrors }) => {
    return (
        <>
            <Input
                {...register('name', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
                type="text"
                id="name"
                label="Nazwa"
                hasError={!!fieldErrors?.name}
                errorMessage={fieldErrors?.name?.message}
                isRequired
            />
            <Input
                {...register('fee', {
                    ...validationRules.required(),
                    ...validationRules.numeric(2),
                })}
                type="text"
                id="fee"
                label="Opłata"
                hasError={!!fieldErrors?.fee}
                errorMessage={fieldErrors?.fee?.message}
                isRequired
            />
        </>
    );
};

export default CarrierFormMainColumn;
