import Select, { ActionMeta, MultiValue, SingleValue } from 'react-select';
import makeAnimated from 'react-select/animated';
import React, { useState } from 'react';
import { SelectOption } from '@admin/common/types/selectOption';

interface ReactSelectProps {
    options: SelectOption[] | undefined;
    value: SelectOption | SelectOption[] | null | undefined;
    hasError?: boolean;
    errorMessage?: string;
    onChange: (value: string | number | any | (string | number | any)[] | null) => void;
    isMulti?: boolean;
    menuPlacement?: 'auto' | 'bottom' | 'top';
}

const ReactSelect: React.FC<ReactSelectProps> = ({
  options,
  value,
  hasError,
  errorMessage,
  onChange,
  isMulti = false,
  menuPlacement = 'bottom',
}) => {

    const handleChange = (
        option: SingleValue<SelectOption> | MultiValue<SelectOption>
    ) => {
        if (isMulti) {
            const values = (option as SelectOption[]).map(opt => opt.value);
            onChange(values);
        } else {
            onChange((option as SelectOption)?.value ?? null);
        }
    };


    return (
      <>
        <Select
          options={options}
          value={value}
          placeholder="Wybierz opcje"
          onChange={handleChange}
          isClearable
          isMulti={isMulti}
          components={makeAnimated()}
          menuPlacement={menuPlacement}
          styles={{
            control: (baseStyles, state) => ({
              ...baseStyles,
              borderColor: hasError ? 'oklch(0.637 0.237 25.331)' : baseStyles.borderColor,
            }),
          }}
        />
        {hasError && (
          <span className="mt-2 text-sm text-red-600">{errorMessage}</span>
        )}
      </>
  )
}

export default ReactSelect;
