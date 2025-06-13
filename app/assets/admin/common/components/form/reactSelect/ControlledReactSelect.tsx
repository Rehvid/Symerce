import { Control, Controller, FieldValues, Path } from 'react-hook-form';
import ReactSelect from '@admin/common/components/form/reactSelect/ReactSelect';
import { SelectOption } from '@admin/common/types/selectOption';
import React from 'react';

interface ControlledReactSelectProps<T extends FieldValues> {
    name: Path<T>;
    control: Control<T>;
    options?: SelectOption[];
    rules?: Record<string, any>;
    isMulti?: boolean;
    children?: React.ReactNode;
}

const ControlledReactSelect = <T extends FieldValues>({
    name,
    control,
    options,
    rules = {},
    isMulti = false,
}: ControlledReactSelectProps<T>) => (
    <Controller
        name={name}
        control={control}
        rules={rules}
        render={({ field, fieldState }) => {
            const selected = isMulti
                ? options?.filter((option) => field.value?.includes(option.value))
                : options?.find((option) => option.value === field.value) || null;

            return (
                <>
                    <ReactSelect
                        options={options}
                        isMulti={isMulti}
                        value={selected}
                        onChange={field.onChange}
                        hasError={fieldState.invalid}
                        errorMessage={fieldState.error?.message}
                        useMenuPortal={true}
                    />
                </>
            );
        }}
    />
);

export default ControlledReactSelect;
