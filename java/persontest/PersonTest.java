class Person {
  String name;
  int age;
  String address;

  Person(String _name, int _age, String _address) {
    name = _name;
    age = _age;
    address = _address;
  }
  void say(){
    System.out.println("���̖��O��" + name + "�ł��B�N���" 
    + age + "�˂ŁA�Z����" + address + "�ł��B");
  }

}

class PersonTest {
  public static void main(String[] args) {
    Person taro = new Person("���Y", 21, "�����s�`��");
    taro.say();

    Person hanako = new Person("�Ԏq", 18, "�k�C���D�y�s");
    hanako.say();
  }
}



