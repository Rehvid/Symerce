import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import { normalizeFiles } from '@/admin/utils/helper';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import Heading from '@/admin/components/common/Heading';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';
import Switch from '@/admin/components/form/controls/Switch';
import { useData } from '@/admin/hooks/useData';
import CurrencyIcon from '@/admin/components/common/CurrencyIcon';
import LabelNameIcon from '@/images/icons/label-name.svg';

const CarrierFormMainColumn = ({ register, fieldErrors, formData, setFormData, setValue }) => {
    const { currency } = useData();
    const formDataImage = normalizeFiles(formData?.image);

    const setDropzoneValue = (image) => {
        setValue('image', image);
        setFormData((prevFormData) => ({
            ...prevFormData,
            image,
        }));
    };

    const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, formDataImage);

    return (
        <>
            <Input
                {...register('name', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
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
                {...register('fee', {
                    ...validationRules.required(),
                    ...validationRules.numeric(currency.roundingPrecision),
                })}
                type="text"
                id="fee"
                label="Opłata"
                hasError={!!fieldErrors?.fee}
                errorMessage={fieldErrors?.fee?.message}
                isRequired
                icon={<CurrencyIcon className="w-[24px] h-[24px]" />}
            />
            <Heading level="h4">
                <span className="flex items-center">Miniaturka</span>
            </Heading>
            <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative max-w-lg" variant="mainColumn">
                {formDataImage.length > 0 &&
                    formDataImage.map((file, key) => (
                        <DropzoneThumbnail file={file} removeFile={removeFile} variant="single" key={key} index={key} />
                    ))}
            </Dropzone>

            <Switch label="Aktywny?" {...register('isActive')} />
        </>
    );
};

export default CarrierFormMainColumn;
