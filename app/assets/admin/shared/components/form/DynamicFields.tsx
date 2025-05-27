import React from "react";
import { useFieldArray, Control, UseFormRegister } from "react-hook-form";
import AppButton from '@admin/components/common/AppButton';
import PlusIcon from '@/images/icons/plus.svg';
import TrashIcon from '@/images/icons/trash.svg';

interface DynamicFieldsProps {
  name: string;
  control: Control<any>;
  register: UseFormRegister<any>;
  renderItem: (fieldIndex: number, fieldName: string, remove: () => void) => React.ReactNode;
  callbackAddClick?: () => void,
}

export const DynamicFields: React.FC<DynamicFieldsProps> = ({ name, control, register, renderItem, callbackAddClick }) => {
  const { fields, append, remove } = useFieldArray({ name, control });

  const handleClick = () => {
    append({});
    callbackAddClick?.();
  }

  return (
    <div>
      {fields.map((field, index) => (
        <div key={field.id} className="mb-[1.25rem] border border-gray-100 p-4 rounded-xl">
          {renderItem(index, `${name}.${index}`, () => remove(index))}
          <div className="flex justify-end mt-5">
            <AppButton
              variant="decline"
              type="button"
              additionalClasses="px-5 py-3 flex gap-2"
              onClick={() => remove(index)}
            >
              <TrashIcon className="w=[24px] h-[24px]" />
              Usuń
            </AppButton>
          </div>
        </div>
      ))}

      <div className="w-full flex justify-end">
        <AppButton
          variant="primary"
          type="button"
          additionalClasses="px-5 py-3 flex gap-2"
          onClick={handleClick}
        >
          <PlusIcon className="w-[24px] h-[24px]" />
          Dodaj
        </AppButton>
      </div>

    </div>
  );
};
