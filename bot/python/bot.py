from aiogram import Bot, types
from aiogram.dispatcher import Dispatcher
from aiogram.utils import executor 

from aiogram.types import ReplyKeyboardRemove, \
    ReplyKeyboardMarkup, KeyboardButton, \
    InlineKeyboardMarkup, InlineKeyboardButton

from config import TOKEN 

bot = Bot(token=TOKEN)
dp = Dispatcher(bot)

regionskb = InlineKeyboardMarkup(row_width=1)
regionButton = InlineKeyboardButton(text='Львівська', callback_data='1') 
regionskb.add(regionButton)

groupskb = InlineKeyboardMarkup(row_width=1)
groupButton = InlineKeyboardButton(text='Група 1', callback_data='1') 
groupskb.add(groupButton)

@dp.message_handler(commands=['start'])
async def process_start_command(message: types.Message):
    await message.reply("Привіт, цей бот буде вас попереджути про відключення світла.\nДля початку виберіть свою область.")
    await message.answer('Області:', reply_markup=regionskb)
 

@dp.message_handler(commands=['start', 'help'])

@dp.message_handler(commands=['help'])
async def process_help_command(message: types.Message):
    await message.reply("Напиши мне что-нибудь, и я отпрпавлю этот текст тебе в ответ!")

@dp.message_handler()
async def echo_message(msg: types.Message):
    await bot.send_message(msg.from_user.id, msg.text)
    print(str(msg))

@dp.callback_query_handler()
async def callback(call: types.CallbackQuery):
  if call.data == "get_schedule":
    await bot.send_message(call.from_user.id, "Повертаємо користувачу якесь повідомлення")
  else:
    await bot.send_message(call.from_user.id, "Виберіть свою групу")
    await  bot.answer('Області:', reply_markup=regionskb)

    print(call.data)

if __name__ == '__main__':
    executor.start_polling(dp)