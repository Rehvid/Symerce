import React from 'react';

const CategoryTreeInput = React.forwardRef(
    ({ selected, category, disabledCategoryId, register, watch, nameWatchedValue }, ref) => {
        const isDisabled = disabledCategoryId === category.id;
        console.log(Number(watch(nameWatchedValue)));
        return (
            <label
                className={`flex items-center gap-2 ${isDisabled ? '' : 'cursor-pointer'} `}
                htmlFor={`category_${category.id}`}
            >
                <input
                    className={`w-5 h-5 ${isDisabled ? '' : 'cursor-pointer'} transition-all duration-500 ease-out transform bg-primary-light text-primary-light
                            ${selected === category.id ? 'scale-110 opacity-100' : 'scale-100 opacity-75'}
                `}
                    {...register}
                    readOnly={isDisabled}
                    id={`category_${category.id}`}
                    type="radio"
                    disabled={isDisabled}
                    value={category.id}
                    checked={Number(watch(nameWatchedValue)) === category.id && !isDisabled}
                />
                {category.name}
            </label>
        );
    },
);
export default CategoryTreeInput;
