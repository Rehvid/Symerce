import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import React from 'react';
import Select from '@/shared/components/Select';

const SettingFormMainColumn = ({ isProtected, register, fieldErrors, formData, setValue }) => {
    const onChange = (e) => {
        setValue('type', e.target.value);
    };

    return (
        <>
            {!isProtected && (
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

                    {formData.types && (
                        <div>
                            Typy
                            <Select onChange={onChange} selected={formData.type} options={formData.types} />
                        </div>
                    )}
                </>
            )}
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
        </>
    );
};

export default SettingFormMainColumn;
