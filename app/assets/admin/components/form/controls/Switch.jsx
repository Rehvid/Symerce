import React from 'react';

const Switch = React.forwardRef(({ label, ...register }, ref) => {
    return (
        <label className="inline-flex items-center cursor-pointer">
            <input {...register} type="checkbox" className="sr-only peer" ref={ref} />
            <div className="relative w-11 h-6 bg-gray-200 peer-focus:outline-none  rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary "></div>
            <span className="ms-3 text-sm font-medium text-gray-900">{label}</span>
        </label>
    );
});

export default Switch;
