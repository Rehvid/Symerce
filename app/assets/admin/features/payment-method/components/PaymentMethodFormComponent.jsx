import { validationRules } from '@/admin/utils/validationRules';
import LabelNameIcon from '@/images/icons/label-name.svg';
import Input from '@/admin/components/form/controls/Input';
import CurrencyIcon from '@/admin/components/common/CurrencyIcon';
import { useData } from '@/admin/hooks/useData';
import Switch from '@/admin/components/form/controls/Switch';
import Heading from '@/admin/components/common/Heading';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';
import { normalizeFiles } from '@/admin/utils/helper';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';

const PaymentMethodFormComponent = ({ register, fieldErrors, setValue, setFormData, formData }) => {
  const { currency } = useData();
  const categoryImage = normalizeFiles(formData?.image);

  const setDropzoneValue = (image) => {
    setValue('thumbnail', image);
    setFormData((prevFormData) => ({
      ...prevFormData,
      image,
    }));
  };

  const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, categoryImage);

  return (
    <>
      <Heading level="h4">
        <span className="flex items-center">Miniaturka</span>
      </Heading>
      <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative max-w-lg" variant="mainColumn">
        {categoryImage.length > 0 &&
          categoryImage.map((file, key) => (
            <DropzoneThumbnail file={file} removeFile={removeFile} variant="single" key={key} index={key} />
          ))}
      </Dropzone>
      <Input
        {...register('name', {
          ...validationRules.required(),
          ...validationRules.minLength(2),
        })}
        type="text"
        id="name"
        label="Nazwa"
        hasError={!!fieldErrors?.name}
        errorMessage={fieldErrors?.name?.message}
        isRequired
        icon={<LabelNameIcon className="text-gray-500 w-[24px] h-[24px]" />}
      />
      <Input
        {...register('code', {
          ...validationRules.required(),
          ...validationRules.minLength(2),
        })}
        type="text"
        id="code"
        label="Nazwa unikatowa (tylko w panelu)"
        hasError={!!fieldErrors?.name}
        errorMessage={fieldErrors?.name?.message}
        isRequired
      />
      <Input
        {...register('fee', {
          ...validationRules.required(),
          ...validationRules.numeric(currency.roundingPrecision),
        })}
        type="text"
        id="fee"
        label="Prowizja"
        hasError={!!fieldErrors?.fee}
        errorMessage={fieldErrors?.fee?.message}
        isRequired
        icon={<CurrencyIcon className="w-[24px] h-[24px]" />}
      />
      <Switch label="Aktywny?" {...register('isActive')} />
      <Switch label="Czy wymaga webhook?" {...register('isRequireWebhook')} />
    </>
  )
}

export default PaymentMethodFormComponent;
