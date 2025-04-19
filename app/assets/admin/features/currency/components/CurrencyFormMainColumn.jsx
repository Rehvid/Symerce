import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import React from 'react';

const CurrencyFormMainColumn = ({ register, fieldErrors }) => {
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
                {...register('code', {
                    ...validationRules.required(),
                })}
                type="text"
                id="code"
                label="Kod waluty"
                hasError={!!fieldErrors?.code}
                errorMessage={fieldErrors?.code?.message}
                isRequired
            />
            <Input
                {...register('symbol', {
                    ...validationRules.required(),
                })}
                type="text"
                id="symbol"
                label="Symbol"
                hasError={!!fieldErrors?.symbol}
                errorMessage={fieldErrors?.symbol?.message}
                isRequired
            />
            <Input
                {...register('roundingPrecision', {
                    ...validationRules.required(),
                    ...validationRules.min(0),
                    ...validationRules.max(8),
                })}
                type="text"
                id="roundingPrecision"
                label="Precyzja zaokrąglenia"
                hasError={!!fieldErrors?.roundingPrecision}
                errorMessage={fieldErrors?.roundingPrecision?.message}
                isRequired
            />
        </>
    );
};

export default CurrencyFormMainColumn;
