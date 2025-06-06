import React from 'react';
import Heading from '@admin/common/components/Heading';

interface SwitchProps extends React.InputHTMLAttributes<HTMLInputElement> {
  label?: string;
  onClick?: () => void;
}

const Switch = React.forwardRef<HTMLInputElement, SwitchProps>(
  ({ label, onClick, ...props }, ref) => {
    return (
      <div>
        <label className="inline-flex items-center cursor-pointer">
          {label && (
            <Heading level="h4">
              <span className="mr-3">{label}</span>
            </Heading>
          )}

          <input
            {...props}
            type="checkbox"
            className="sr-only peer"
            ref={ref}
            // onClick={onClick}
          />

          <div className="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary" />
        </label>
      </div>
    );
  }
);

Switch.displayName = 'Switch';

export default Switch;
