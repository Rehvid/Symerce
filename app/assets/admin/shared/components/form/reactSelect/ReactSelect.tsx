import Select from 'react-select';
import makeAnimated from 'react-select/animated';
import { useState } from 'react';

const ReactSelect = ({
  options,
  value,
  hasError,
  errorMessage,
  onChange,
  isMulti,
}) => {
  return (
      <>
        <Select
          options={options}
          value={value}
          placeholder="Wybierz opcje"
          onChange={onChange}
          isClearable
          isMulti={isMulti}
          components={makeAnimated()}
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
