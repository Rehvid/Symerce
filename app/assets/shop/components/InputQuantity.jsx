import MinusIcon from '@/images/icons/minus.svg';
import PlusIcon from '@/images/icons/plus.svg';
import { useEffect, useState } from 'react';


const InputQuantity = ({ id, onChange, quantity = 1, }) => {
  const [inputValue, setInputValue] = useState(quantity);

  useEffect(() => {
    setInputValue(quantity); // aktualizuj jeśli quantity się zmieni z zewnątrz
  }, [quantity]);


  const onChangeButton = (method) => {
    const newValue = method === 'decrease' ? quantity - 1 : quantity + 1
    onChange?.(newValue, method);
  }

  const onChangeHandler = (e) => {
    setInputValue(e.target.value);
  }

  const onBlurHandler = () => {
    const numericValue = Number(inputValue);
    if (!isNaN(numericValue)) {
      onChange?.(numericValue);
    } else {
      setInputValue(quantity);
    }
  };


  return (
    <div className="inline-flex items-center border border-gray-300 rounded-full overflow-hidden">
      <button
        className="px-3 py-3 transition-all duration-300 bg-gray-100 hover:bg-gray-200 cursor-pointer btn-quantity-change"
        onClick={() => onChangeButton('decrease')}
      >
        <MinusIcon />
      </button>
      <input
        type="text"
        className="w-full sm:w-16 text-center outline-none border-gray-300"
        id={id}
        value={inputValue}
        onChange={onChangeHandler}
        onBlur={onBlurHandler}
      />
      <button
        className="px-3 py-3 transition-all duration-300 bg-gray-100 hover:bg-gray-200 cursor-pointer btn-quantity-change"
        onClick={() => onChangeButton('increase')}
      >
        <PlusIcon />
      </button>
    </div>

  )
}

export default InputQuantity;
