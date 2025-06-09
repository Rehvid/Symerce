import React from 'react';
import { Control, useFieldArray, UseFormRegister } from 'react-hook-form';
import Button, { ButtonVariant } from '@admin/common/components/Button';
import PlusIcon from '@/images/icons/plus.svg';
import TrashIcon from '@/images/icons/trash.svg';

interface DynamicFieldsProps {
    name: string;
    control: Control<any>;
    renderItem: (fieldIndex: number, fieldName: string, remove: () => void) => React.ReactNode;
    callbackAddClick?: () => void;
}

export const DynamicFields: React.FC<DynamicFieldsProps> = ({
    name,
    control,
    renderItem,
    callbackAddClick,
}) => {
    const { fields, append, remove } = useFieldArray({ name, control });

    const handleClick = () => {
        append({});
        callbackAddClick?.();
    };

    return (
        <div>
            {fields.map((field, index) => (
                <div key={field.id} className="mb-[1.25rem] border border-gray-100 p-4 rounded-xl">
                    {renderItem(index, `${name}.${index}`, () => remove(index))}
                    <div className="flex justify-end mt-5">
                        <Button
                            variant={ButtonVariant.Decline}
                            type="button"
                            additionalClasses="px-5 py-3 flex gap-2"
                            onClick={() => remove(index)}
                        >
                            <TrashIcon className="w=[24px] h-[24px]" />
                            Usuń
                        </Button>
                    </div>
                </div>
            ))}

            <div className="w-full flex justify-end">
                <Button
                    variant={ButtonVariant.Primary}
                    type="button"
                    additionalClasses="px-5 py-3 flex gap-2"
                    onClick={handleClick}
                >
                    <PlusIcon className="w-[24px] h-[24px]" />
                    Dodaj
                </Button>
            </div>
        </div>
    );
};
