import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import React from 'react';
import Select from '@/shared/components/Select';

const DeliveryTimeFormMainColumn = ({ register, fieldErrors, formData, setValue }) => {
    const onChange = (e) => {
        setValue('type', e.target.value);
    };

    console.log(formData);

    return (
        <>
            <Input
                {...register('label', {
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
                {...register('minDays', {
                    ...validationRules.required(),
                    ...validationRules.min(0),
                })}
                type="text"
                id="minDays"
                label="Minimalne dni"
                hasError={!!fieldErrors?.maxDays}
                errorMessage={fieldErrors?.maxDays?.message}
                isRequired
            />
            <Input
                {...register('maxDays', {
                    ...validationRules.required(),
                    ...validationRules.min(1),
                })}
                type="text"
                id="maxDays"
                label="Maksymalne Dni"
                hasError={!!fieldErrors?.minDays}
                errorMessage={fieldErrors?.minDays?.message}
                isRequired
            />

            {formData.types && (
                <div>
                    Typy
                    <Select onChange={onChange} selected={formData.type} options={formData.types} />
                </div>
            )}
        </>
    );
};

export default DeliveryTimeFormMainColumn;
