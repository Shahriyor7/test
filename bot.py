from os import remove
from aiogram import types, Bot, Dispatcher
from aiogram.types import InputFile
from aiogram.utils import executor
from random import choice
from string import ascii_lowercase
from aiogram import types
from aiogram.dispatcher.filters import BoundFilter, CommandStart

bot =Bot(token="5707338133:AAF6fxlvAGInIkwfLPE86v9FECA20HSiXys")
dp = Dispatcher(bot)

#FILTRLASH BO'LIM
class Kanal(BoundFilter):
    async def check(self, message: types.Message):
        return message.chat.type == types.ChatType.CHANNEL
class Shaxsiy(BoundFilter):
    async def check(self, message: types.Message):
        return message.chat.type == types.ChatType.PRIVATE

def rand():
    result_str = ''.join(choice(ascii_lowercase) for i in range(5))
    return result_str

@dp.message_handler(Shaxsiy(), CommandStart())
async def bot_start(message: types.Message):
    user_id = message.from_user.id
    await bot.send_message(chat_id=user_id, text=f"<b>Salom Meni Kanalingizga admin qilsangiz musiqalarga kanal nomini qoʻyib beraman</b>",reply_markup=types.InlineKeyboardMarkup().add(types.InlineKeyboardButton
  ("Ulashish ♻️",url=f"https://t.me/share/url?url=https://t.me/{post.chat.username}/{post.message_id+1}")))

@dp.channel_post_handler(Kanal(),content_types=['audio'])
async def post_in_channel(post: types.Message):
    username ="@" + post.chat.username if post.chat.username is not None else "*" + + post.chat.title + "*"
    chanel_caption = post.caption

    if chanel_caption == None: chanel_caption = ''
    x = rand()
    print(x)
    try:
        await bot.delete_message(chat_id=post.chat.id,message_id=post.message_id)
        poss = await post.audio.download(x + ".mp3")
    except:
     return
    audio_url = InputFile(path_or_bytesio=x + ".mp3")
    await bot.send_audio(chat_id=post.chat.id, audio=audio_url,title=post.audio.title,
    performer=username.replace("*", ""), duration=post.audio.duration,
   caption=f"{chanel_caption}\n\n<b>ᴊᴏɪɴ ➣</b> @{post.chat.username} 🎧🖤",
  reply_markup=types.InlineKeyboardMarkup().add(types.InlineKeyboardButton
  ("Ulashish ♻️",url=f"https://t.me/share/url?url=https://t.me/{post.chat.username}/{post.message_id+1}")))
    d = x + ".mp3"
    remove(d)

if __name__ == '__main__':
    executor.start_polling(dp)
