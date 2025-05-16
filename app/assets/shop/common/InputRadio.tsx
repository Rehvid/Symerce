import React from 'react';

export type InputRadioProps = {
  id: string;
  name?: string;
  value?: string;
  isRequired?: boolean;
  checked?: boolean;
  onChange?: (event: React.ChangeEvent<HTMLInputElement>) => void;
  containerClassName?: string;
  children?: React.ReactNode;
} & React.InputHTMLAttributes<HTMLInputElement>;

const InputRadio = React.forwardRef<HTMLInputElement, InputRadioProps>(
  (
    {
      id,
      name,
      value,
      isRequired = false,
      checked,
      onChange,
      containerClassName = '',
      children,
      ...rest
    },
    ref
  ) => {
    return (
      <div className={containerClassName}>
        <input
          type="radio"
          id={id}
          name={name}
          value={value}
          className="hidden peer"
          required={isRequired}
          checked={checked}
          onChange={onChange}
          ref={ref}
          {...rest}
        />
        <label
          htmlFor={id}
          className="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:border-primary hover:ring-1 hover:ring-primary transition-all duration-300"
        >
          {children}
        </label>
      </div>
    );
  }
);

InputRadio.displayName = 'InputRadio';

export default InputRadio;
