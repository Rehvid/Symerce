import React from 'react';
import Error from '@admin/common/components/Error';


type CommonProps = {
  className?: string;
  errorMessage?: string;
};

type RegisteredProps = {
  register: any;
  checked?: never;
  onChange?: never;
  name?: never;
};

type ManualProps = {
  register?: never;
  checked?: boolean;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
  name?: string;
};

type Props = CommonProps & (RegisteredProps | ManualProps);

const Switch = React.forwardRef<HTMLInputElement, Props>(
  ({ className, errorMessage, ...rest }, ref) => {
    const inputProps =
      'register' in rest
        ? { ...rest.register, ref }
        : { onChange: rest.onChange, checked: rest.checked, name: rest.name, ref };

    return (
      <div>
        <label className="inline-flex items-center cursor-pointer">
          <input type="checkbox" className="sr-only peer" {...inputProps} />
          <div
            className={`relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary ${className ?? ''}`}
          ></div>
        </label>
          <Error message={errorMessage} />
      </div>
    );
  }
);

Switch.displayName = 'Switch';

export default Switch;
